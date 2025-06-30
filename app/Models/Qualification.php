<?php
// app/Models/Qualification.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Qualification extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'name',
        'year',
        'institution',
        'country',
        'user_id',
        'program_name', // Added program_name field

    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
