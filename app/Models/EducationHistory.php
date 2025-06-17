<?php

// app/Models/EducationHistory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EducationHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'name',
        'year',
        'institution',
        'country',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
