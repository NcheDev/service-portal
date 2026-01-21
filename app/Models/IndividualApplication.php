<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndividualApplication extends Model
{
    protected $fillable = [
        'application_id','studied_at',
        'qualification_name','award','nationality_id'
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
    public function nationality()
    {
        return $this->belongsTo(Country::class, 'nationality_id');
    }
                
}
