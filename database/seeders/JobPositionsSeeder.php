<?php

namespace Database\Seeders;

use App\Models\JobPosition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobPositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JobPosition::factory()->create([
            'name' => 'Developper',
        ]);

        JobPosition::factory()->create([
            'name' => 'Office Call Center Operator',
        ]);

        JobPosition::factory()->create([
            'name' => 'Tester',
        ]);
    }
}
