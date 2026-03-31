<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model {
    use HasFactory;
    protected $fillable = ['user_id','noteable_id','noteable_type','body'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function noteable() {
        return $this->morphTo();
    }
}

