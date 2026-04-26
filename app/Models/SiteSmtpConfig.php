<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSmtpConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'mailer',
        'host',
        'port',
        'username',
        'password',
        'encryption',
        'from_address',
        'from_name',
        'is_verified',
    ];

    protected $casts = [
        'port' => 'integer',
        'is_verified' => 'boolean',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
