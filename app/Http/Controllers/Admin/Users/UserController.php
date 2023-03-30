<?php

namespace App\Http\Controllers\Admin\Users;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;

class UserController extends Controller
{
    public function users()
    {

        $users = User::orderBy('updated_at', 'DESc')->get();
        $userActivations = User::$userActivations;
        $userTypes = User::$userTypes;
        return view('admin.users.users', compact('users', 'userActivations', 'userTypes'));
    }
    public function edit(User $user)
    {

        return view('admin.users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $inputs = [
            'activation' => $request->activation,
            'user_type' => $request->user_type
        ];
        $user->update($inputs);
        return redirect()->route('admin.users.users')->with('swal-success', 'User Updated Successfully');
    }
    
    public function wallets(User $user)
    {

        $wallets = Wallet::where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();
        return view('admin.wallets.wallets', compact('wallets'));
    }

    public function transactions(Wallet $wallet)
    {
        $transactions = Transaction::where('wallet_id', $wallet->id)->orderBy('created_at', 'DESC')->get();
        $user = $wallet->user;
        return view('admin.transactions.transactions', compact('transactions', 'user', 'wallet'));
    }
}
