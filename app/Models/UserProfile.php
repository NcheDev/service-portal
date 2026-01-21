<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id','first_name','last_name','previous_names',
        'primary_contact','secondary_contact',
        'nationality_id','country_id','national_id_number',
        'gender_id','title_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
