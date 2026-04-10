<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id','title','description','total_amount','status','notes'
    ];
    protected $casts = ['notes'=>'array'];
    public function client() { return $this->belongsTo(Client::class); }
    public function invoices() { return $this->hasMany(Invoice::class); }

    protected static function booted()
    {
        static::created(function ($project) {
            echo "CREATED PROJECT: #{$project->id}, Title: {$project->title}, Status: {$project->status}<br>";
        });

        static::updated(function ($project) {
            echo "UPDATE PROJECT: #{$project->id}, Title: {$project->title}, Status: {$project->status}<br>";
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
        if ($this->status === 'draft') {
            return; // остаётся draft пока не запущен
        }

        if ($this->invoices()->whereIn('status',['pending','partially_paid','partially_refunded'])->exists()) {
            $this->status = 'active';
        } elseif ($this->invoices()->where('status','canceled')->exists()) {
            $this->status = 'canceled';
        } elseif ($this->invoices()->whereIn('status',['refunded','partially_refunded'])->exists()) {
            $this->status = 'paused';
        } elseif ($this->invoices()->where('status','paid')->count() === $this->invoices()->count()) {
            $this->status = 'completed';
        }

        $this->save();
    }
}

