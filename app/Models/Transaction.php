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
            $transaction->invoice->recalcFromTransactions();
        });

        // При обновлении транзакции
        static::updated(function ($transaction) {
            if ($transaction->isDirty('status') || $transaction->isDirty('amount')) {
                $transaction->invoice->recalcFromTransactions();
            }
        });
    }
}
