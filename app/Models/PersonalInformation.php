<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'physical_address',
        'contact_address',
        'gender',
        'personal_statement',
        'profile_picture',
        'cover_photo',
        'national_id_path',
        'country',
    'date_of_birth',
    'next_of_kin',
    'title',
    'previous_surnames',
    'national_id_number',
    'kin_contact',
    ];
}
