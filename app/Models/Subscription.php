<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model {
    use HasFactory;
    protected $fillable = ['client_id','title','price','billing_period','start_date','next_payment_date','status'];

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }
    public function notes() {
        return $this->morphMany(Note::class, 'noteable');
    }
}

