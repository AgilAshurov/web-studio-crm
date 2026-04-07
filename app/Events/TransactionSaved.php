<?php

namespace App\Events;


use App\Models\Transaction;
use Illuminate\Queue\SerializesModels;

class TransactionSaved
{
    use SerializesModels;

    public $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }
}

