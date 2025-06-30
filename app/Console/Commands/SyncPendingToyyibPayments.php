<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Pendaftaran;
use App\Models\Payment;

class SyncPendingToyyibPayments extends Command
{
    protected $signature = 'payments:sync-toyyib';
    protected $description = 'Sync all unpaid pendaftarans with ToyyibPay transactions';

    public function handle()
    {
        $pendaftarans = Pendaftaran::where('is_paid', false)->get();
        $secretKey = env('TOYYIBPAY_SECRET_KEY');

        $this->info("🔄 Checking " . $pendaftarans->count() . " unpaid records...");

        foreach ($pendaftarans as $pendaftar) {
            $billCode = $pendaftar->bill_code;

            if (!$billCode) {
                $this->warn("⚠️ No bill_code for ID {$pendaftar->id}");
                continue;
            }

            $response = Http::asForm()->post('https://toyyibpay.com/index.php/api/getBillTransactions', [
                'billCode' => $billCode,
                'userSecretKey' => $secretKey,
            ]);

            if (!$response->ok()) {
                $this->error("❌ Failed to query billCode: {$billCode}");
                continue;
            }

            $transactions = $response->json();
            if (!empty($transactions) && isset($transactions[0]['status']) && $transactions[0]['status'] == '1') {
                $pendaftar->is_paid = true;
                $pendaftar->save();

                $this->info("✅ Marked paid: {$pendaftar->nama} [{$billCode}]");

                // Optional: store transaction details
                Payment::create([
                    'billcode' => $billCode,
                    'refno' => $transactions[0]['refNo'] ?? null,
                    'status' => 1,
                    'amount' => $transactions[0]['amount'] ?? null,
                    'paydate' => $transactions[0]['paydate'] ?? null,
                    'transaction_data' => json_encode($transactions[0]),
                ]);
            } else {
                $this->line("⏳ Still unpaid: {$pendaftar->nama} [{$billCode}]");
            }
        }

        $this->info("✅ Done syncing.");
    }
}