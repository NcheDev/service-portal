<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutionApplicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'first_name',
        'surname',
        'email',
        'nationality',
        'title',
        'dob',
        'phone',
    ];

    // Link to application
    public function application()
    {
        return $this->belongsTo(Application::class);
    }


    // Applicant has many qualifications
    public function qualifications()
    {
        return $this->hasMany(Qualification::class, 'applicant_id');
    }

    // Applicant has many documents
    public function documents()
    {
        return $this->hasMany(Document::class, 'applicant_id');
    }
}
