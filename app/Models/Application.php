<?php
// app/Models/Application.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory;

   protected $fillable = [
    'user_id',
    'processing_type',
    'nationality',
    'status',
    'response_report_path',  // Path to the response report
    'validation_comment',
];

public function qualification()
{
    return $this->hasOne(Qualification::class);
}

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function qualifications()
    {
        return $this->hasMany(Qualification::class);
    }

    public function educationHistories()
    {
        return $this->hasMany(EducationHistory::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
