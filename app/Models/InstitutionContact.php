<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstitutionContact extends Model
{
    protected $fillable = [
        'institution_application_id',
        'first_name','last_name','phone','nationality_id'
    ];

    public function institution()
    {
        return $this->belongsTo(InstitutionApplication::class);
    }
    public function nationality()
    {
        return $this->belongsTo(Country::class, 'nationality_id');
    }

    /**
     * Link back to parent institution application
     */
    public function institutionApplication()
    {
        return $this->belongsTo(InstitutionApplication::class);
    }
}
