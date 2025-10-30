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
            'name' => 'Customer Service Specialist With Foreign Languages',
        ]);

        JobPosition::factory()->create([
            'name' => 'Software Developer With VBA Experience',
        ]);

        JobPosition::factory()->create([
            'name' => 'Hardware Services Inventory Planner',
        ]);

        JobPosition::factory()->create([
            'name' => 'GSMR Test Engineer',
        ]);

        JobPosition::factory()->create([
            'name' => 'Optical Transmission Test Engineer',
        ]);

        JobPosition::factory()->create([
            'name' => 'Front Office Analyst with English and German',
        ]);

        JobPosition::factory()->create([
            'name' => 'Network Automation Engineer',
        ]);

        JobPosition::factory()->create([
            'name' => 'Optical Transmission Design and Configuration Engineer',
        ]);

        JobPosition::factory()->create([
            'name' => 'Monter szaf telekomunikacyjnych',
        ]);
    }
}
