<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Pendaftaran;
use App\Models\WebhookLog;

class PendaftaranController extends Controller
{
    public function create()
    {
        return view('daftar');
    }

    public function store(Request $request)
    {
        
        \Log::info('🚀 Store method hit.', ['data' => $request->all()]);
        
        try {
            $request->validate([
                'nama'     => 'required|string|max:100',
                'kelas'    => 'required|string|max:20',
                'jawatan'  => 'required|string|max:100',
                'ic'       => 'required|regex:/^\d{6}-\d{2}-\d{4}$/',
                'jantina'  => 'required|in:Lelaki,Perempuan',
                'agama'    => 'required|string',
                'telefon'  => 'required|string|max:20',
                'email'    => 'nullable|email',
                'alergik'  => 'nullable|string|max:500',
                'sumbangan' => 'nullable|numeric|min:0',
            ]);
            \Log::info('✅ Validation passed.', []);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('❌ Validation failed', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        }

        $baseAmountRM = 190;
        $sumbangan = is_numeric($request->input('sumbangan')) ? (int) $request->input('sumbangan') : 0;
        \Log::info('💵 Sumbangan processed: ' . $sumbangan);
        $totalAmountRM = $baseAmountRM + $sumbangan;
        $totalAmountSen = $totalAmountRM * 100;
        $billRef = uniqid('SSP');
        \Log::info('💵 Total processed: ' . $totalAmountRM);

        $pendaftaran = Pendaftaran::create([
            'nama'         => $request->nama,
            'kelas'        => $request->kelas,
            'jawatan'      => $request->jawatan,
            'ic'           => $request->ic,
            'jantina'      => $request->jantina,
            'agama'        => $request->agama,
            'telefon'      => $request->telefon,
            'email'        => $request->email,
            'alergik'      => $request->alergik,
            'sumbangan'    => $sumbangan,
            'total_amount' => $totalAmountSen,
            'bill_ref'     => $billRef,
        ]);

        $billData = [
            'userSecretKey'          => config('services.toyyibpay.secret_key'),
            'categoryCode'           => config('services.toyyibpay.category_code'),
            'billName'               => 'Kursus Kepimpinan SSP 2025',
            'billDescription'        => "Peserta: {$request->nama} ({$request->kelas})",
            'billPriceSetting'       => 1,
            'billPayorInfo'          => 1,
            'billAmount'             => $totalAmountSen,
            'billReturnUrl'          => config('services.toyyibpay.return_url'),
            'billCallbackUrl'        => route('toyyibpay.callback'),
            'billExternalReferenceNo'=> $billRef,
            'billTo'                 => $request->nama,
            'billEmail'              => $request->email,
            'billPhone'              => $request->telefon,
            'billSplitPayment'       => 0,
            'billPaymentChannel'     => 0,
        ];

        $response = Http::asForm()->post('https://toyyibpay.com/index.php/api/createBill', $billData);
        $body = $response->json();
        \Log::info('🔁 ToyyibPay Response:', $body);

        if (isset($body[0]['BillCode'])) {
            $pendaftaran->bill_code = $body[0]['BillCode'];
            $pendaftaran->save();

            return redirect("https://toyyibpay.com/{$body[0]['BillCode']}");
        }

        return back()->with('status', 'Ralat semasa menjana bil.');
        return back()->withErrors(['msg' => 'Reached end, no bill code.']);
    }

    public function receipt(Request $request)
    {
        $billCode = $request->query('billcode');

        if (!$billCode) {
            return view('receipt')->with('error', 'BillCode not found.');
        }

        $pendaftaran = Pendaftaran::where('bill_code', $billCode)->first();
        \Log::info('📦 Receipt Lookup:', ['billCode' => $billCode, 'result' => $pendaftaran]);
        if (!$pendaftaran) {
            return view('receipt')->with('error', 'Rekod tidak dijumpai.');
        }

        // Only call ToyyibPay API if not yet paid
        if (!$pendaftaran->is_paid) {
            try {
                $response = Http::asForm()->post('https://toyyibpay.com/index.php/api/getBillTransactions', [
                    'billCode' => $billCode
                ]);

                $transactions = $response->json();

                if (is_array($transactions)) {
                    // ✅ Look for at least one successful payment
                    foreach ($transactions as $txn) {
                        if (isset($txn['billpaymentStatus']) && $txn['billpaymentStatus'] == '1') {
                            // ✅ Log this successful payment
                            DB::table('webhook_logs')->insert([
                                'bill_code' => $billCode,
                                'payload' => json_encode($txn),
                                'source' => 'receipt-check',
                                'created_at' => now(),
                            ]);

                            // ✅ Update local status
                            $pendaftaran->is_paid = true;
                            $pendaftaran->save();
                            break;
                        }
                    }
                }
            } catch (\Throwable $e) {
                \Log::error("ToyyibPay API error for $billCode: " . $e->getMessage());
            }
        }

            // Check if payment is complete
            if ($pendaftaran->is_paid) {
                return view('receipt', [
                    'pendaftaran' => $pendaftaran,
                    'paid' => true
                ]);
            }

            return view('receipt', [
                'pendaftaran' => $pendaftaran,
                'pending' => true
            ]);
    }

    public function callback(Request $request)
    {
        Log::info('ToyyibPay Callback Received', $request->all());

        $billCode = $request->get('billcode');

        if (!$billCode) {
            Log::warning("Callback missing billcode");
            return response('No billcode', 400);
        }

        $pendaftaran = Pendaftaran::where('bill_code', $billCode)->first();

        if (!$pendaftaran) {
            Log::warning("Callback billcode not found: " . $billCode);
            return response('Not found', 404);
        }

        $pendaftaran->is_paid = true;
        $pendaftaran->save();

        Log::info("Payment marked as paid for bill_code: " . $billCode);

        return response('OK', 200);
    }

    public function listPaid()
    {
        $peserta = Pendaftaran::where('is_paid', 1)
            ->orderBy('jawatan')
            ->orderByRaw("CAST(SUBSTRING_INDEX(kelas, ' ', 1) AS UNSIGNED) DESC")
            ->orderBy('kelas')
            ->get()
            ->groupBy('jawatan');

        return view('participants.list', compact('peserta'));
    }
}