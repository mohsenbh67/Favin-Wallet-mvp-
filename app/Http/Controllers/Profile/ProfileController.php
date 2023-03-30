<?php

namespace App\Http\Controllers\Profile;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function profile(){

        $user = User::where('id', auth()->user()->id)->first();
        return view('profile.profile', compact('user'));


    }

    public function editProfile(){


        $user = User::where('id', auth()->user()->id)->first();
        return view('profile.edit-profile', compact('user'));

    }

    public function updateProfile(UpdateProfileRequest $request){

        $inputs = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'national_code' => $request->national_code,
            'email' => $request->email
        ];
        $user = auth()->user();
        $user->update($inputs);
        return redirect()->route('admin.profile')->with('swal-success', 'Profile updated successfully');



    }
}
