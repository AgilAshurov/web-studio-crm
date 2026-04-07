<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Events\TransactionSaved;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_id','type','currency','amount','status','reference','date'];
    protected $casts = ['date'=>'datetime'];

    public function invoice(){ return $this->belongsTo(Invoice::class); }

    protected $dispatchesEvents = [
        'saved' => TransactionSaved::class,
    ];



/*
    public function applyToInvoice(): void
    {
        if ($this->status === 'success') {
            $invoice = $this->invoice;
            $invoice->$invoice->updateStatusByLastTransaction();
            $invoice->handleOverpayment();
        }
    }
    protected static function booted()
    {
        static::created(function ($transaction) {
            $invoice = $transaction->invoice;

            if ($transaction->type === 'debit') {
                $invoice->updateStatusByLastTransaction();
                $invoice->handleOverpayment();
            }

            if ($transaction->type === 'refund') {
                if ($invoice->factical_amount <= 0) {
                    throw new \Exception("Нельзя вернуть средства: баланс подписки равен 0");
                }
                $invoice->updateStatusByLastTransaction();
            }
        });
    }*/
}


