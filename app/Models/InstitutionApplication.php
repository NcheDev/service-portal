<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstitutionApplication extends Model
{
    protected $fillable = [
        'application_id','institution_name',
        'registration_number','country_id'
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function contacts()
    {
        return $this->hasMany(InstitutionContact::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}

