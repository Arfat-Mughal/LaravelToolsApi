<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'name',
        'email',
        'subject',
        'message',
        'fields',
        'status',
        'ip_address',
        'user_agent',
        'notified_at',
        'replied_at',
        'reply_message',
    ];

    protected $casts = [
        'fields' => 'array',
        'notified_at' => 'datetime',
        'replied_at' => 'datetime',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
