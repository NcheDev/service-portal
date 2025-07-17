<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    protected $fillable = [
        'user_id', 'event', 'auditable_type', 'auditable_id',
        'old_values', 'new_values', 'ip_address', 'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    // Optional relation to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
