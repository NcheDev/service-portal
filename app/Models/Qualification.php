<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    protected $fillable = [
        'application_id','qualification_name',
        'award','institution_name'
    ];
}

