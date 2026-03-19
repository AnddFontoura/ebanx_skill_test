<?php

namespace App\Http\Requests\AccountBalance;

use Illuminate\Foundation\Http\FormRequest;

class AccountBalanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'account_id' => 'required|integer|exists:account,id',
        ];
    }
}
