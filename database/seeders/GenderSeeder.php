<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gender;

class GenderSeeder extends Seeder
{
    public function run(): void
    {
        $genders = [
            'Male',
            'Female',
            
        ];

        foreach ($genders as $gender) {
            Gender::updateOrCreate(['name' => $gender]);
        }
    }
}
