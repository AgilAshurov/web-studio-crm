<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model {
    use HasFactory;
    protected $fillable = [
        'client_id','project_id','subscription_id',
        'amount','payment_date','payment_method',
        'period_start','period_end'
    ];
    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function subscription() {
        return $this->belongsTo(Subscription::class);
    }
}

