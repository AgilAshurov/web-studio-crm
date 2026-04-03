<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['client_id','title','price','billing_period','start_date','end_date','next_invoice_date','payment_method','status','notes'];
    protected $casts = ['start_date'=>'date','end_date'=>'date','next_invoice_date'=>'date','notes'=>'array'];

    public function client(){ return $this->belongsTo(Client::class); }
    public function invoices(){ return $this->hasMany(Invoice::class); }

    /** Создание нового инвойса из подписки */
    public function createInvoice(): Invoice
    {
        return $this->invoices()->create([
            'client_id' => $this->client_id,
            'subscription_id' => $this->id,
            'currency' => $this->currency ?? 'AZN',
            'amount' => $this->price,
            'factual_amount' => 0,
            'status' => 'pending',
            'billing_period_start' => $this->start_date,
            'billing_period_end' => $this->end_date,
        ]);
    }
}
