<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'nationality',
        'qualification_type',
        'processing_type',
    ];

    public function documents()
    {
        return $this->hasMany(ApplicationDocument::class);
    }
}
