<?php

namespace App\Http\Requests\AccountBalance;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountBalanceNewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $type = $this->input('type');

        return [
            'type' => 'required|string|in:deposit,withdraw,transfer',
            'amount' => 'required|numeric',

            'origin' => [
                'nullable',
                'string',
                Rule::requiredIf(in_array($type, ['withdraw','transfer']))
            ],

            'destination' => [
                'nullable',
                'string',
                Rule::requiredIf(in_array($type, ['deposit','transfer']))
            ],
        ];
    }
}
