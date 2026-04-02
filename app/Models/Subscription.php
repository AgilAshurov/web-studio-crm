<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id','title','price','billing_period',
        'start_date','next_invoice_date','payment_method','status','notes'
    ];

    public function client() { return $this->belongsTo(Client::class); }
    public function invoices() { return $this->hasMany(Invoice::class); }
}

