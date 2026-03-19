<?php

namespace App\Http\Requests\AccountBalance;

use Illuminate\Foundation\Http\FormRequest;

class AccountBalanceNewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => 'required|string',
            'amount' => 'required|numeric',
            'origin' => 'required|string',
            'destination' => 'nullable|string',
        ];
    }
}
