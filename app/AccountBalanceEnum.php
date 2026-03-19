<?php

namespace App;

enum AccountBalanceEnum: string
{
    case Deposit = '1';
    case Withdraw = '2';

    case Transfer = '3';
}
