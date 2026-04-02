<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id','client_id','subscription_id',
        'period_start','period_end','amount','paid_amount',
        'payment_date','payment_method','status','notes'
    ];

    public function client() { return $this->belongsTo(Client::class); }
    public function project() { return $this->belongsTo(Project::class); }
    public function subscription() { return $this->belongsTo(Subscription::class); }
    public function transactions() { return $this->hasMany(Transaction::class); }
}

