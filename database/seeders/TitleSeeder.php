<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Title;

class TitleSeeder extends Seeder
{
    public function run(): void
    {
        $titles = [
            'Mr',
            'Mrs',
            'Ms',
            'Dr',
            'Prof',
        ];

        foreach ($titles as $title) {
            Title::updateOrCreate(['name' => $title]);
        }
    }
}
