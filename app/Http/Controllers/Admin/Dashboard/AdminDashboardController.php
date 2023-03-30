<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    public function index(){

        
        $wallets = Wallet::where([['user_id' , auth()->user()->id], ['status', '1']])->orderBy('created_at', 'Desc')->get();
        $user = User::where('id' , auth()->user()->id)->first();
        return view('Admin.Dashboard.dashboard', compact('wallets', 'user'));

    }
}
