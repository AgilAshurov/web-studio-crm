<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id','subscription_id','amount','factical_amount','status','currency',
        'billing_period_start','billing_period_end'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function recalcFromTransactions()
    {
        $debits = $this->transactions()
            ->where('status', 'success')
            ->where('type', 'debit')
            ->sum('amount');

        $refunds = $this->transactions()
            ->where('status', 'success')
            ->where('type', 'refund')
            ->sum('amount');

        $facticalAmount = $debits - $refunds;
        $this->factical_amount = max(0, min($facticalAmount, $this->amount));

        if ($this->factical_amount >= $this->amount) {
            $this->status = 'paid';
            $remaining = $facticalAmount - $this->amount;
            $this->applyOverpayment($remaining);
        } elseif ($this->factical_amount > 0) {
            $this->status = 'partially_paid';
        } elseif ($refunds > 0) {
            // вот здесь различаем полный и частичный возврат
            if ($refunds < $debits) {
                $this->status = 'partially_refunded';
            } else {
                $this->status = 'refunded';
            }
        } else {
            $this->status = 'pending';
        }

        $this->saveQuietly();
    }


    public function applyOverpayment($remaining)
    {
        // Логика распределения переплаты по другим счетам или создание новых
    }
}
