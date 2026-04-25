<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WalletController extends Controller
{
    /** Show wallet dashboard (balance + transaction history) */
    public function index(Request $request)
    {
        $user = $request->user();
        $transactions = $user->walletTransactions()->paginate(15);

        return view('wallet.index', compact('user', 'transactions'));
    }

    /** Show top-up form */
    public function showTopUp()
    {
        return view('wallet.topup');
    }

    /** Process top-up */
    public function topUp(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1|max:10000',
        ], [
            'amount.required' => 'Zadaj sumu.',
            'amount.min'      => 'Minimálna suma je 1 €.',
            'amount.max'      => 'Maximálna suma je 10 000 €.',
        ]);

        $cents = (int) round($request->amount * 100);
        $request->user()->topUp($cents, 'Manuálne dobíjanie (testovací režim)');

        return redirect()->route('wallet.index')
            ->with('success', 'Kredit bol pridaný: ' . number_format($request->amount, 2) . ' €');
    }
}