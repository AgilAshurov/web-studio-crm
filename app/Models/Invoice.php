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

    protected static function booted()
    {
        // При создании транзакции
        static::created(function ($invoice) {
            echo "<br><br>CREATED INVOICE:  #{$invoice->id}, Amount: {$invoice->amount}, FAmount: {$invoice->factical_amount}, Status: {$invoice->status}<br>";
//
        });

        // При обновлении транзакции
        static::updated(function ($invoice) {
            echo "UPDATE INVOICE:  #{$invoice->id}, Amount: {$invoice->amount}, FAmount: {$invoice->factical_amount}, Status: {$invoice->status}<br>";
        });
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


        if ($refunds > $debits) {
//            throw new \Exception("Сумма возврата не может быть больше фактической суммы");
            echo "ERROR: Сумма возврата не может быть больше фактической суммы";
            return;
        }

        $this->factical_amount = $facticalAmount;

        // Логика статусов
        if ($refunds > 0) {
            if ($this->factical_amount >= $this->amount) {
                $this->status = 'paid';
            } elseif ($this->factical_amount > 0) {
                $this->status = 'partially_refunded';
            } else {
                $this->status = 'refunded';
            }
        } else {
            if ($this->factical_amount >= $this->amount) {
                $this->status = 'paid';
            } elseif ($this->factical_amount > 0) {
                $this->status = 'partially_paid';
            } else {
                $this->status = 'pending';
            }
        }

        $this->save();
    }

}
