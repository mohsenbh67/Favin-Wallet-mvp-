<?php

namespace App\Http\Controllers\Auth\Register;

use Carbon\Carbon;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\Message\MessageService;
use App\Http\Services\Message\Email\EmailService;
use App\Http\Requests\Auth\Register\RegisterRequest;

class RegisterController extends Controller
{



    public function registerForm()
    {

        return view('auth.register.register');
    }


    public function register(RegisterRequest $request)
    {

        $inputs = $request->all();
        if (filter_var($inputs['email'], FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $inputs['email'])->first();
            if (empty($user)) {
                $inputs['activation'] = 1;
                $inputs['email'] = strtolower($inputs['email']);
                $inputs['password'] = bcrypt($inputs['password']);
                $user = User::create($inputs);
            } elseif ($user->email_verified_at) {
                $errorText = 'Already Registered';
                return redirect()->route('register-form')->with('swal-error', $errorText);
            }
        } else {
            $errorText = 'Invalid Email Address';
            return redirect()->route('register-form')->with('swal-error', $errorText);
        }



        //create otp code
        $otpCode = rand(111111, 999999);
        $token = Str::random(60);
        $otpInputs = [
            'token' => $token,
            'user_id' => $user->id,
            'otp_code' => $otpCode,
        ];

        Otp::create($otpInputs);

        //send email

        $emailService = new EmailService();
        $details = [
            'title' => 'Activation Email',
            'body' => "Activation Code: $otpCode"
        ];
        $emailService->setDetails($details);
        $emailService->setFrom('icpherking@gmail.com', 'Email');
        $emailService->setSubject('Activation code');
        $emailService->setTo($inputs['email']);

        $messagesService = new MessageService($emailService);

        $messagesService->send();

        return redirect()->route('register-confirm-form', $token);
    }

    public function registerConfirmForm($token)
    {
        $otp = Otp::where('token', $token)->first();
        if (empty($otp)) {
            return redirect()->route('register-form')->with('swal-error', 'Invalid Code');
        }
        return view('auth.register.register-confirm', compact('token', 'otp'));
    }

    public function registerConfirm($token, RegisterRequest $request)
    {
        $inputs = $request->all();
        $sentOtp = Otp::where('token', $token)->first();
        $user = $sentOtp->user()->first();
        $otp = Otp::where('token', $token)->where('used', 0)->where('created_at', '>=', Carbon::now()->subMinute(5)->toDateTimeString())->first();
        if (empty($otp)) {
            $sentOtp->delete();
            $user->delete();
            return redirect()->route('register-confirm-form', $token)->with('swal-error', 'Try Again');
        }

        //if otp not match
        if ($otp->otp_code !== $inputs['otp']) {
            return redirect()->route('register-confirm-form', $token)->with('swal-error', 'Invalid Code');
        }

        // if everything is ok :
        $otp->update(['used' => 1]);
        if (empty($user->email_verified_at)) {
            $user->update(['email_verified_at' => Carbon::now()]);
        }
        Auth::login($user);
        return redirect()->route('admin.dashboard');
    }

    public function registerResendOtp($token)
    {
        $otp = Otp::where('token', $token)->where('created_at', '<=', Carbon::now()->subMinutes(5)->toDateTimeString())->first();

        if (empty($otp)) {
            return redirect()->route('register-form', $token)->with('swal-error', 'Try Again');
        }




        $user = $otp->user()->first();
        //create otp code
        $otpCode = rand(111111, 999999);
        $token = Str::random(60);
        $otpInputs = [
            'token' => $token,
            'user_id' => $user->id,
            'otp_code' => $otpCode,
        ];

        Otp::create($otpInputs);

        //send email

        $emailService = new EmailService();
        $details = [
            'title' => 'Activation Email',
            'body' => "Activation Code: $otpCode"
        ];
        $emailService->setDetails($details);
        $emailService->setFrom('icpherking@gmail.com', 'Email');
        $emailService->setSubject('Activation code');
        $emailService->setTo($user->email);

        $messagesService = new MessageService($emailService);


        $messagesService->send();

        return redirect()->route('register-confirm-form', $token);
    }
}
