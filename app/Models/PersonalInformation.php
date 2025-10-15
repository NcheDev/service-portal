<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'surname',
        'email',
        'physical_address',
        'contact_address',
        'gender',

        'profile_picture',
        'cover_photo',
         'country',
    'date_of_birth',
    'title',
     'national_id_number',
    'institution_name',
         'application_type'  ,
         'primary_phone',
         'secondary_phone',
         'primary_country_code',
         'institution_position',
         'nationality'

    ];
}
