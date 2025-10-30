<?php

namespace Database\Factories;

use App\Models\Applicant;
use App\Models\JobPosition;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * Factory for pivot applicant_job_position rows
 */
class Applicant_JobPositionFactory extends Factory
{
    protected $model = null; // pivot nie ma modelu Eloquent domyślnie

    public function definition(): array
    {
        // Domyślne wartości (jeśli ktoś użyje bez stanów)
        return [
            'applicant_id' => Applicant::query()->inRandomOrder()->value('id'),
            'job_position_id' => JobPosition::query()->inRandomOrder()->value('id'),
        ];
    }

    public function forApplicant(int $applicantId): self
    {
        return $this->state(fn () => ['applicant_id' => $applicantId]);
    }

    public function forJobPosition(int $jobPositionId): self
    {
        return $this->state(fn () => ['job_position_id' => $jobPositionId]);
    }
}
