<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'iso_code',
    ];

    /**
     * Users with this nationality
     */
    public function nationals()
    {
        return $this->hasMany(UserProfile::class, 'nationality_id');
    }

    /**
     * Users residing in this country
     */
    public function residents()
    {
        return $this->hasMany(UserProfile::class, 'country_id');
    }
}
