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

    public function calculatePaidAmount() : float{
        return $this->transactions()
            ->where('status','success')
            ->where('type', 'debit')
            ->where('amount');
    }

    public function calculateRefundAmount() : float{
        return $this->transactions()
            ->where('status','success')
            ->where('type', 'refund')
            ->where('amount');
    }

    public function updateStatusByLastTransaction() : void
    {
        //Если успешная статус по последний транзакции
        $lastTransaction = $this->transactions()
            ->where('status','success')
            ->orderByDesc('date')
            ->first();
        //последняя транзакция
        if (!$lastTransaction) {
            $this->status = 'pending';
            $this->factual_amount = 0;
            $this->save();
            return;
        }
        //отменненая транзакция
        if($this->status == 'canceled'){
            return;
        }
        //частичная оплата или полная
        if($lastTransaction->type == 'debit'){
            $this->factical_amount += $lastTransaction->amount;
            $this->status = $this->factical_amount >= $this->amount ? 'paid' : 'partially_paid';
        }
        //частичная изъятие средств или полное
        if($lastTransaction->type == 'refund'){
            $this->factical_amount -= $lastTransaction->amount;
            $this->status = $this->factical_amount <= 0 ? 'refuned' : 'partially_refuned';
        }
        $this->save();
    }
    public function handleOverpayment() : void{

        $overpaid = $this->factual_amount - $this->amount;

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
            $invoice->factual_amount += $apply;
            $invoice->updateStatus();

            $overpaid -= $apply;

            if($overpaid > 0){
                $nextInvoice = Invoice::where('subscription_id', $invoice->subscription_id)
                    ->where('billing_period_start', '<', $invoice->billing_period_start)
                    ->orderBy('billing_period_start')
                    ->first();
                if($nextInvoice){
                    $nextInvoice->factual_amount += $overpaid;
                    $nextInvoice->updateStatus();
                }
            }

        }
    }
}

