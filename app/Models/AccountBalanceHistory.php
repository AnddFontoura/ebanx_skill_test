<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountBalanceHistory extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'account_id',
        'account_balance_id',
        'balance',
        'deposit',
        'withdraw',
    ];
}
