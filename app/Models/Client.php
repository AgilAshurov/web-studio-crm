<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name','website_url','server_info',
        'billing_contact','tech_contact','status','notes'
    ];

    protected $casts = [
        'billing_contact' => 'array',
        'tech_contact' => 'array',
        'notes'=>'array',
    ];

    public function projects() { return $this->hasMany(Project::class); }
    public function subscriptions() { return $this->hasMany(Subscription::class); }
    public function invoices() { return $this->hasMany(Invoice::class); }
}

