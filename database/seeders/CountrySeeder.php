<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            ['name' => 'Malawi', 'iso_code' => 'MW'],
            ['name' => 'Zambia', 'iso_code' => 'ZM'],
            ['name' => 'Tanzania', 'iso_code' => 'TZ'],
            ['name' => 'Mozambique', 'iso_code' => 'MZ'],
            ['name' => 'South Africa', 'iso_code' => 'ZA'],
            ['name' => 'Kenya', 'iso_code' => 'KE'],
            ['name' => 'Uganda', 'iso_code' => 'UG'],
            ['name' => 'Zimbabwe', 'iso_code' => 'ZW'],
            ['name' => 'Nigeria', 'iso_code' => 'NG'],
            ['name' => 'United Kingdom', 'iso_code' => 'GB'],
            ['name' => 'United States', 'iso_code' => 'US'],
            ['name' => 'India', 'iso_code' => 'IN'],
        ];

        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['iso_code' => $country['iso_code']],
                $country
            );
        }
    }
}
