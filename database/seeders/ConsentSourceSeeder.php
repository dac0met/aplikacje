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
            'key' => 'web',
            'label' => 'Strona internetowa',
        ]);

        ConsentSource::factory()->create([
            'key' => 'email',
            'label' => 'Email',
        ]);
    }
}
