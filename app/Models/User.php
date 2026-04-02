<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'remember_token' => 'string',
        ];
    }

    // Связь с сессиями
    public function sessions() {
        return $this->hasMany(Session::class);
    }

    // Связь с токенами сброса пароля (опционально)
    public function passwordResetTokens() {
        return $this->hasMany(PasswordResetToken::class, 'email', 'email');
    }
}
