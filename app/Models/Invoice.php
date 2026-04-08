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

        // Логика статусов
        if ($refunds > 0) {
            if ($refunds < $debits) {
                $this->status = 'partially_refunded';
            } else {
                $this->status = 'refunded';
            }
        } elseif ($this->factical_amount >= $this->amount) {
            $this->status = 'paid';
        } elseif ($this->factical_amount > 0) {
            $this->status = 'partially_paid';
        } else {
            $this->status = 'pending';
        }

        $this->saveQuietly();
    }
    public function getFacticalAmountRaw()
    {
        $debits = $this->transactions()
            ->where('status', 'success')
            ->where('type', 'debit')
            ->sum('amount');

        $refunds = $this->transactions()
            ->where('status', 'success')
            ->where('type', 'refund')
            ->sum('amount');

        return $debits - $refunds; // «сырое» значение без ограничений
    }
}
