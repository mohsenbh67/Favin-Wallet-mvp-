<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'title' => 'required|string|max:120|min:1',
            'description' => 'nullable|max:120|min:1',
            'amount' => 'required|numeric|max:100000000|min:1000',
            'status' => 'in:deposit,withdraw',
            'published_at' => 'required|date',
        ];
    }
}
