<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01'
        ]);

        $user = Auth::user();
        $amount = $request->input('amount');

        // Get total withdrawals for the day
        $dailyWithdrawals = $user->transactions()
            ->where('type', 'withdrawal')
            ->whereDate('created_at', now()->toDateString())
            ->sum('amount');

        if ($dailyWithdrawals + $amount > 3000) {
            return back()->withErrors(['amount' => 'Daily withdrawal limit exceeded.']);
        }

        if ($amount > $user->balance) {
            return back()->withErrors(['amount' => 'Insufficient balance.']);
        }

        $withdrawalsThisMonth = $user->transactions()
            ->where('type', 'withdrawal')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        $fee = 0;
        if ($withdrawalsThisMonth >= 3) {
            $fee = 5;
        } else if ($amount > 1000) {
            $fee = $amount * 0.02;
        } else if ($amount >= 500) {
            $fee = $amount * 0.01;
        }

        $transaction = new Transaction([
            'type' => 'withdrawal',
            'amount' => $amount,
            'fee' => $fee,
        ]);

        $user->transactions()->save($transaction);
        $user->balance -= ($amount + $fee);
        $user->save();

        return back()->with('success', 'Withdrawal successful.');
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01'
        ]);

        $user = Auth::user();
        $amount = $request->input('amount');

        $transaction = new Transaction([
            'type' => 'deposit',
            'amount' => $amount,
            'fee' => 0,
        ]);

        $user->transactions()->save($transaction);
        $user->balance += $amount;
        $user->save();

        return back()->with('success', 'Deposit successful.');
    }
}
