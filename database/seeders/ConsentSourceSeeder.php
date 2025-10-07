<?php

namespace Database\Seeders;

use App\Models\ConsentSource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConsentSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ConsentSource::factory()->create([
            'name' => 'Strona internetowa',
        ]);

        ConsentSource::factory()->create([
            'name' => 'Email',
        ]);
    }
}
