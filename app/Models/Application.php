<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'application_type',
        'processing_type',
        'status',
        'current_step',
        'submitted'
    ];

    const STEPS = [
        'profile',
        'details',
        'documents',
        'preview',
        'submitted',
    ];

    // ------------------------
    // RELATIONSHIPS
    // ------------------------

    // Individual application details
    public function individualApplication()
    {
        return $this->hasOne(\App\Models\IndividualApplication::class);
    }

    // Institution application details
    public function institutionApplication()
    {
        return $this->hasOne(\App\Models\InstitutionApplication::class);
    }

    // Documents uploaded for this application
    public function documents()
    {
        return $this->hasMany(\App\Models\Document::class);
    }

    // Owner user
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
