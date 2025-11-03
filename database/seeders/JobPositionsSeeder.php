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
            'published' => true,
            'filename' => 'customer_service_specialist_with_foreign_languages.pdf',
            
        ]);

        JobPosition::factory()->create([
            'name' => 'Software Developer With VBA Experience',
            'published' => true,
            'filename' => 'software_developer_with_vba_experience.pdf',
        ]);

        JobPosition::factory()->create([
            'name' => 'Hardware Services Inventory Planner',
            'published' => true,
            'filename' => 'hardware_services_inventory_planner.pdf',
        ]);

        JobPosition::factory()->create([
            'name' => 'GSMR Test Engineer',
            'published' => true,
            'filename' => 'gsmr_test_engineer.pdf',
        ]);

        JobPosition::factory()->create([
            'name' => 'Optical Transmission Test Engineer',
            'published' => false,
            'filename' => 'optical_transmission_test_engineer.pdf',
        ]);

        JobPosition::factory()->create([
            'name' => 'Front Office Analyst with English and German',
            'published' => true,
            'filename' => 'front_office_analyst_with_english_and_german.pdf',
        ]);

        JobPosition::factory()->create([
            'name' => 'Network Automation Engineer',
            'published' => true,
            'filename' => 'network_automation_engineer.pdf',
        ]);

        JobPosition::factory()->create([
            'name' => 'Optical Transmission Design and Configuration Engineer',
            'published' => true,
            'filename' => 'optical_transmission_design_and_configuration_engineer.pdf',
        ]);

        JobPosition::factory()->create([
            'name' => 'Monter szaf telekomunikacyjnych',
            'published' => true,
            'filename' => 'monter_szaf_telekomunikacyjnych.pdf',
        ]);
    }
}
