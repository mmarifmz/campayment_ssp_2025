<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    use Illuminate\Support\Facades\DB;

    public function show($billcode)
    {
        $payment = DB::table('payments')
            ->where('billcode', $billcode)
            ->first();

        if (!$payment) {
            abort(404);
        }

        return view('receipt.show', compact('payment'));
    }
}
