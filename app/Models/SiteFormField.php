<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteFormField extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'field_key',
        'label',
        'type',
        'is_required',
        'validation_rules',
        'sort_order',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
