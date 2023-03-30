<?php

namespace App\Http\Controllers\Admin\Transactions;

use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Transaction\TransactionRequest;

class TransactionController extends Controller
{
    public function transactions(Wallet $wallet)
    {

        if (!Gate::allows('wallet', $wallet)) {
            return redirect()->route('admin.dashboard');
        }

        $user = Auth::user();
        $transactions = Transaction::where('wallet_id', $wallet->id)->orderBy('created_at', 'DESC')->get();
        return view('admin.transactions.transactions', compact('transactions', 'user', 'wallet'));
    }



    public function deposit(Wallet $wallet)
    {
        if (!Gate::allows('wallet', $wallet)) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.transactions.deposit', compact('wallet'));
    }

    public function withdraw(Wallet $wallet)
    {
        if (!Gate::allows('wallet', $wallet)) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.transactions.withdraw', compact('wallet'));
    }

    public function store(TransactionRequest $request, wallet $wallet)
    {
        if (!Gate::allows('wallet', $wallet)) {
            return redirect()->route('admin.dashboard');
        }
        if ($wallet->status === 1) {
            $published_at = strtotime($request->published_at);
            $amount = $wallet->amount;
            $inputs = [
                'user_id' => Auth::user()->id,
                'wallet_id' => $wallet->id,
                'title' => $request->title,
                'description' => $request->description,
                'amount' => $request->amount,
                'published_at' => date("Y-m-d H:i:s", (int) $published_at),
            ];
            if ($request->status === 'deposit') {
                $inputs['status'] = '0';
                Transaction::create($inputs);
                $amount =   $amount + $request->amount;
                $wallet->update([
                    'user_id' => Auth::user()->id,
                    'amount' => $amount,
                ]);
            } else {
                if ($request->amount > $amount) {
                    return redirect()->route('admin.wallets.wallets')->with('swal-error', 'Transaction failed');
                } else {

                    $inputs['status'] = '1';
                    Transaction::create($inputs);
                    $amount =   $amount - $request->amount;
                    $wallet->update([
                        'user_id' => Auth::user()->id,
                        'amount' => $amount,
                    ]);
                }
            }
            return redirect()->route('admin.wallets.wallets')->with('swal-success', 'Transaction Created Successfully');
        }



        return redirect()->route('admin.wallets.wallets')->with('swal-error', 'Transaction failed, Wallet in not Active');
    }
}
