<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model {
    use HasFactory;
    protected $fillable = ['client_id','title','total_amount','paid_amount','status'];
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

