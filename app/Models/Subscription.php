<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'currency',
        'price',
        'status',
        'start_date',
        'end_date',
        'title',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'notes'      => 'array',
    ];

    // 🔗 Связь с инвойсами
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    protected static function booted()
    {
        static::created(function ($subscription) {
            echo "CREATED SUBSCRIPTION: #{$subscription->id}, Title: {$subscription->title}, Status: {$subscription->status}<br>";
        });

        static::updated(function ($subscription) {
            echo "UPDATE SUBSCRIPTION: #{$subscription->id}, Title: {$subscription->title}, Status: {$subscription->status}<br>";
        });
    }

    public function applyPayment($amount)
    {
        $unpaidInvoices = $this->invoices()
            ->whereNotIn('status',['paid','canceled','refunded'])
            ->orderBy('billing_period_start')
            ->get();

        foreach ($unpaidInvoices as $invoice) {
            $needed = $invoice->amount - $invoice->factical_amount;
            if ($needed > 0) {
                $apply = min($amount, $needed);
                $invoice->factical_amount += $apply;
                $invoice->status = $invoice->factical_amount >= $invoice->amount ? 'paid' : 'partially_paid';
                $invoice->save();

                $amount -= $apply;
                if ($amount <= 0) break;
            }
        }
        $this->refreshStatus();
    }
    public function refreshStatus()
    {
        if ($this->invoices()->whereIn('status',['pending','partially_paid','partially_refunded','refunded'])->exists()) {
            $this->status = 'paused';
        } elseif ($this->invoices()->where('status','canceled')->exists()) {
            $this->status = 'canceled';
        } elseif ($this->end_date && $this->end_date < now()) {
            $this->status = 'expired';
        } else {
            $this->status = 'active';
        }
        $this->save();
    }
}
