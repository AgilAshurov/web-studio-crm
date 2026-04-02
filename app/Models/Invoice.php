<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['client_id','project_id','subscription_id','billing_period_start','billing_period_end','amount','paid_amount','payment_date','payment_method','status','notes'];
    protected $casts = ['billing_period_start'=>'date','billing_period_end'=>'date','payment_date'=>'datetime','notes'=>'array'];

    public function client(){ return $this->belongsTo(Client::class); }
    public function project(){ return $this->belongsTo(Project::class); }
    public function subscription(){ return $this->belongsTo(Subscription::class); }
    public function transactions(){ return $this->hasMany(Transaction::class); }
}

