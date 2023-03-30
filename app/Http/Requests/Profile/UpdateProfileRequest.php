<?php

namespace App\Http\Requests\Profile;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
        return [
            'first_name' => 'required|min:1|max:20',
            'last_name' => 'required|min:1|max:20',
            'email' => 'required|email|max:30',
            'national_code' => ['required','integer', Rule::unique('users')->ignore($this->user()->national_code, 'national_code')],
        ];
    }
}
