<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Site extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'site_key',
        'name',
        'url',
        'description',
        'is_active',
        'admin_email',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function smtpConfig()
    {
        return $this->hasOne(SiteSmtpConfig::class);
    }

    public function formFields()
    {
        return $this->hasMany(SiteFormField::class)->orderBy('sort_order');
    }

    public function submissions()
    {
        return $this->hasMany(ContactSubmission::class);
    }
}
