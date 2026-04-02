<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id','type','amount','status','reference','date'
    ];

    public function invoice() { return $this->belongsTo(Invoice::class); }
}

