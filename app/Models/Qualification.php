<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'award',
        'issuing_institution',
        'certificate_country',
        'year_obtained',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
