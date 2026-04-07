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

    // 🔧 Метод для создания инвойса
    public function createInvoice(Carbon $periodStart = null, Carbon $periodEnd = null): Invoice
    {
        $periodStart = $periodStart ?? $this->start_date ?? now();
        $periodEnd   = $periodEnd ?? $this->end_date ?? now()->addMonth();

        return $this->invoices()->create([
            'client_id'            => $this->client_id,
            'subscription_id'      => $this->id,
            'currency'             => $this->currency ?? 'AZN',
            'amount'               => $this->price,
            'factical_amount'      => 0,
            'status'               => 'pending',
            'billing_period_start' => $periodStart,
            'billing_period_end'   => $periodEnd,
        ]);
    }

    // ⚡ ORM события
    protected static function booted()
    {
        // При создании подписки сразу создаём первый инвойс
        static::created(function ($subscription) {
            $subscription->createInvoice();
        });

        // При обновлении подписки
        static::updated(function ($subscription) {
            if ($subscription->status === 'canceled') {
                $subscription->invoices()
                    ->where('status', 'pending')
                    ->update(['status' => 'canceled']);
            }
        });

        // При удалении подписки
        static::deleted(function ($subscription) {
            $subscription->invoices()->delete();
        });
    }
}
