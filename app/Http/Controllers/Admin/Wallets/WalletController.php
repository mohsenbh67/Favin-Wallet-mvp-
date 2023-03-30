<?php

namespace App\Http\Controllers\Admin\Wallets;

use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Wallet\WalletRequest;

class WalletController extends Controller
{
    public function Wallets(){

        $user = Auth::user();
        $wallets = Wallet::where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();
        return view('admin.wallets.wallets', compact('wallets'));

    }
    public function createNewWallet(){


        return view('admin.wallets.create-new-wallet');

    }

    public function store(WalletRequest $request){

        $inputs = $request->all();
        $inputs['user_id']= auth()->user()->id;
        Wallet::create($inputs);
        return redirect()->route('admin.wallets.wallets')->with('swal-success', 'Wallet Created Successfully');

    }


    public function edit(Wallet $wallet){

        if(!Gate::allows('wallet', $wallet)){
            return redirect()->route('admin.dashboard');
        }
        return view('admin.wallets.edit', compact('wallet'));

    }


    
    public function update(WalletRequest $request, Wallet $wallet){

        if(!Gate::allows('wallet', $wallet)){
            return redirect()->route('admin.dashboard');
        }
        $inputs = $request->all();
        $inputs['user_id']= auth()->user()->id;
        $wallet->update($inputs);
        return redirect()->route('admin.wallets.wallets')->with('swal-success', 'Wallet Updated Successfully');

    }
}
