<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name','website_url','server_info',
        'billing_contact','tech_contact','status','notes'
    ];

    protected $casts = [
        'billing_contact' => 'array',
        'tech_contact' => 'array',
        'notes'=>'array',
    ];

    public function projects() { return $this->hasMany(Project::class); }
    public function subscriptions() { return $this->hasMany(Subscription::class); }
    public function invoices() { return $this->hasMany(Invoice::class); }

    //Общая сумма всех инвойсов
    public function totalInvoicesAmount()
    {
        return $this->invoices()->sum('amount');
    }

    //Общая сумма оплаченных
    public function totalPaidAmount()
    {
        return $this->invoices()->where('status','paid')->sum('amount');
    }

    //Общая задолженность
    public function totalDebt()
    {
        return $this->invoices()
            ->whereNotIn('status',['paid','canceled','refunded'])
            ->sum(DB::raw('amount - factical_amount'));
    }

    public function totalBalance()
    {
        return $this->invoices()->sum('amount');
    }

    //Количество активных проектов
    public function activeProjectsCount()
    {
        return $this->projects()->where('status','active')->count();
    }

    //Количество активных подписок
    public function activeSubscriptionsCount()
    {
        return $this->subscriptions()->where('status','active')->count();
    }

    //Применение оплаты на уровне клиента
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
        if ($this->projects()->where('status','active')->exists() ||
            $this->subscriptions()->where('status','active')->exists()) {
            $this->status = 'active';
        } elseif ($this->projects()->count() === 0 && $this->subscriptions()->count() === 0) {
            $this->status = 'prospect';
        } else {
            $this->status = 'inactive';
        }

        $this->save();
    }
}

