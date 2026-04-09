<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_id','amount','status','type','reference', 'date'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    protected static function booted()
    {
        // При создании транзакции
        static::created(function ($transaction) {
            echo "<br>Transaction#{$transaction->id} → Type: {$transaction->type}, Amount: {$transaction->amount}<br>";

            $transaction->invoice->recalcFromTransactions();

        });

        // При обновлении транзакции
        static::updated(function ($transaction) {
            echo "<br>UPDATE Transaction#{$transaction->id} → Type: {$transaction->type}, Amount: {$transaction->amount}<br>";
            if ($transaction->isDirty('status') || $transaction->isDirty('amount')) {
                $transaction->invoice->recalcFromTransactions();
            }
        });
    }
}
