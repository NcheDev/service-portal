<?php

// app/Models/Document.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'type',
        'file_path',
        
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
   
   
}
