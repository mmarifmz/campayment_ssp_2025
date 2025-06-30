<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Pendaftaran;
use App\Models\Payment;

class SyncPendingToyyibPayments extends Command
{
    protected $signature = 'payments:sync-toyyib';
    protected $description = 'Sync all unpaid pendaftarans with ToyyibPay transactions';

    public function handle()
    {
        $this->info('🔄 Checking unpaid records...');

        $unpaid = DB::table('pendaftarans')->where('is_paid', 0)->get();

        $this->info("🔍 Found {$unpaid->count()} unpaid records.");

        foreach ($unpaid as $record) {
            if (!$record->bill_code) {
                \Log::warning("⚠️ No bill_code for ID {$record->id}");
                continue;
            }

            $this->line("🔁 Syncing bill_code: {$record->bill_code}");

            try {
                $response = Http::asForm()->post('https://dev.toyyibpay.com/index.php/api/getBillTransactions', [
                    'billCode' => $record->bill_code,
                    'secretKey' => config('toyyibpay.secret_key'),
                ]);

                $transactions = $response->json();

                \Log::info("📦 API response for {$record->bill_code}: " . json_encode($transactions));

                if (!is_array($transactions) || empty($transactions)) {
                    \Log::warning("⚠️ No valid transactionStatus found for {$record->bill_code}");
                    continue;
                }

                // Get successful transaction (billpaymentStatus = 1)
                $successTxn = collect($transactions)->firstWhere('billpaymentStatus', '1');

                if (!$successTxn) {
                    \Log::warning("⚠️ No successful payment for {$record->bill_code}");
                    continue;
                }

                // Attempt to extract student name
                $studentName = $successTxn['billTo'] ?? 'Unknown';

                if ($studentName === 'Unknown' && !empty($successTxn['billDescription'])) {
                    if (preg_match('/Peserta:\s(.+?)\s\(/', $successTxn['billDescription'], $matches)) {
                        $studentName = $matches[1];
                    }
                }

                // Mark payment as paid
                DB::table('pendaftarans')
                    ->where('id', $record->id)
                    ->update([
                        'is_paid' => 1,
                        'updated_at' => now(),
                    ]);

                $this->info("✅ Marked as paid: {$studentName} ({$record->bill_code})");

            } catch (\Exception $e) {
                \Log::error("❌ Error syncing bill_code {$record->bill_code}: " . $e->getMessage());
                $this->error("❌ Failed for {$record->bill_code}");
            }
        }

        $this->info('🎉 Sync complete.');
    }
}