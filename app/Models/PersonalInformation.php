<?php
//app/Models/PersonalInformation.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'contact_address',
        'physical_address',
        'email',
        'national_id_path',
        'personal_statement',
    ];
}
