<?php

namespace App\Http\Controllers\Auth\Login;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\Login\LoginRequest;

class LoginController extends Controller
{

    public function loginForm()
    {
        return view('auth.login.login');
    }

    public function loginConfirm(LoginRequest $request)
    {

        $inputs = $request->all();

        $user = User::where('email', $inputs['email'])->first();
        if(empty($user)){
            $errorText = 'You are not Registered';
            return redirect()->route('register-form')->with('swal-error', $errorText);
        }
        if ($user->activation === 0) {
            $errorText = 'You are not allowed to login';
            return redirect()->route('login-form')->with('swal-error', $errorText);
        }

        // set the remember me cookie if the user check the box
        $remember = (isset($inputs['remember'])) ? true : false;


        // attempt to do the login
        $auth = Auth::attempt(
            [
                'email'  => strtolower($inputs['email']),
                'password'  => $inputs['password']
            ],
            $remember
        );
        if ($auth) {
            return redirect()->route('admin.dashboard');
        } else {
            $errorText = 'Invalid Email Address';
            return redirect()->route('login-form')->with('swal-error', $errorText);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login-form');
    }
}
