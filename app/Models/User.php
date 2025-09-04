<?php

namespace App\Models;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\PersonalInformation;
use App\Models\Qualification;
use App\Models\Application;
 
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;


    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
         'profile_picture_path'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
// User.php

 
 

public function personalInformation()
{
    return $this->hasOne(PersonalInformation::class);
}

public function qualifications()
{
    return $this->hasMany(Qualification::class); // once the table is created
}

 
public function personalInfo()
{
return $this->hasOne(PersonalInformation::class);}
public function Applications()
{
    return $this->hasMany(Application::class);
}
public function invoices()
{
    return $this->hasMany(\App\Models\Invoice::class);
}
 


}
