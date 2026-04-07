<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['client_id','project_id','subscription_id','billing_period_start','billing_period_end','currency','amount','factical_amount','payment_date','payment_method','status','notes'];
    protected $casts = ['billing_period_start'=>'date','billing_period_end'=>'date','payment_date'=>'datetime','notes'=>'array'];

    public function client(){ return $this->belongsTo(Client::class); }
    public function project(){ return $this->belongsTo(Project::class); }
    public function subscription(){ return $this->belongsTo(Subscription::class); }
    public function transactions(){ return $this->hasMany(Transaction::class); }

    /*protected static function booted()
    {
        static::created(function ($invoice) {
            $invoice->handleOverpayment();
        });

        static::updated(function ($invoice) {
            $invoice->updateStatusByLastTransaction();
        });
    }*/
   /* public function getFacticalAmountAttribute()
    {
        $debits = $this->transactions()->where('type', 'debit')->sum('amount');
        $refunds = $this->transactions()->where('type', 'refund')->sum('amount');
        return $debits - $refunds;
    }
    public function updateStatusByLastTransaction(): void
    {
        $lastTransaction = $this->transactions()
            ->where('status','success')
            ->orderByDesc('date')
            ->first();

        if (!$lastTransaction) {
            $this->status = 'pending';
            $this->factical_amount = 0;
            return;
        }

        if ($this->status === 'canceled') return;

        if ($lastTransaction->type === 'debit') {
            $this->factical_amount += $lastTransaction->amount;
            $this->status = $this->factical_amount >= $this->amount ? 'paid' : 'partially_paid';
        }

        if ($lastTransaction->type === 'refund') {
            if ($this->factical_amount <= 0) {
                throw new \Exception("Нельзя вернуть средства: баланс подписки равен 0");
            }
            $this->factical_amount -= $lastTransaction->amount;
            $this->status = $this->factical_amount <= 0 ? 'refunded' : 'partially_refunded';
        }
    }

    public function handleOverpayment() : void{

        $overpaid = $this->factical_amount - $this->amount;

        if($overpaid <= 0){
            return;
        }

        $pendingInvoices = Invoice::where('client_id', $this->client_id)
            ->where('status', 'pending')
            ->orderBy('billing_period_start')
            ->get();

        foreach($pendingInvoices as $invoice){
            if($overpaid <= 0){
                break;
            }
            $needed = $invoice->amount - $invoice->factical_amount;
            if($needed <= 0){
                break;
            }

            $apply = min($overpaid, $needed);
            $invoice->factical_amount += $apply;
            $invoice->updateStatusByLastTransaction();

            $overpaid -= $apply;
        }
        while ($overpaid > 0 && $this->subscription) {
            $apply = min($overpaid, $this->subscription->price);

            $newInvoice = $this->subscription->createInvoice();
            $newInvoice->factical_amount = $apply;
            $newInvoice->status = $apply >= $newInvoice->amount ? 'paid' : 'partially_paid';
            $newInvoice->save();

            $overpaid -= $apply;
        }
    }*/
}

