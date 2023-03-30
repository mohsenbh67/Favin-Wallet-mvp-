<?php

namespace App\Http\Requests\Auth\Register;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $route = Route::current();
        if($route->getName() == 'register')
        {
            return [
                            
            'first_name' => 'required|min:1|max:20',
            'last_name' => 'required|min:1|max:20',
            'email' => 'required|email|max:30',
            'password' => 'confirmed|min:6'
             ];
        }
        elseif($route->getName() == 'register-confirm')
        {
            return [
                'otp' => 'required|min:6|max:6',
             ];
        }
    }
}
