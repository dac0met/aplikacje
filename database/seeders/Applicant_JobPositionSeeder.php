<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\JobPosition;
use Illuminate\Database\Seeder;

class Applicant_JobPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobPositionIds = JobPosition::query()->pluck('id')->all();
        if (empty($jobPositionIds)) {
            return; // brak pozycji – nie ma co łączyć
        }

        Applicant::query()->chunkById(500, function ($applicants) use ($jobPositionIds) {
            foreach ($applicants as $applicant) {
                $max = min(3, count($jobPositionIds));
                $count = rand(1, $max);
                $ids = collect($jobPositionIds)->random($count);
                $applicant->jobPositions()->sync($ids); // nadpisujemy zestaw dla spójności
            }
        });
    }
}
