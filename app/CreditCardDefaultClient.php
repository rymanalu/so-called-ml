<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditCardDefaultClient extends Model
{
    protected $table = 'credit_card_default_clients';

    protected $casts = [
        'limit_balance' => 'decimal:4',
        'bill_statement_1' => 'decimal:4',
        'bill_statement_2' => 'decimal:4',
        'bill_statement_3' => 'decimal:4',
        'bill_statement_4' => 'decimal:4',
        'bill_statement_5' => 'decimal:4',
        'bill_statement_6' => 'decimal:4',
        'previous_payment_1' => 'decimal:4',
        'previous_payment_2' => 'decimal:4',
        'previous_payment_3' => 'decimal:4',
        'previous_payment_4' => 'decimal:4',
        'previous_payment_5' => 'decimal:4',
        'previous_payment_6' => 'decimal:4',
        'is_next_month_default' => 'boolean',
    ];
}
