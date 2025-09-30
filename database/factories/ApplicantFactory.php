<?php

namespace Database\Factories;

use App\Models\Applicant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Applicant>
 */
class ApplicantFactory extends Factory
{
    /** Nazwa modelu, którego dotyczy factory */
    protected $model = Applicant::class;

    public function definition()
    {
        // Lista przykładowych języków i poziomów
        $languages = ['Dutch', 'Polish', 'German', 'Spanish', 'French'];
        $levels    = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'];

        // Generujemy losowy numer telefonu (międzynarodowy format)
        $phone = $this->faker->unique()->numberBetween(500000000, 799999999);

        return [
            'job_position_id'  => $this->faker->numberBetween(1, 3),
            'consent_source_id'=> $this->faker->numberBetween(1, 2),
            'submitted_date'   => $this->faker->dateTimeBetween('-1 year', 'now'),
            'user_ip'          => $this->faker->ipv4,
            'name'             => $this->faker->firstName,
            'surname'          => $this->faker->lastName,
            'yob'              => $this->faker->numberBetween(1950, 2005),
            'city'             => $this->faker->city,
            'phone'            => $phone,
            'email'            => $this->faker->unique()->safeEmail,
            'consent'          => $this->faker->randomElement(['yes', 'no']),
            'education'        => $this->faker->randomElement(['High School', 'Bachelor', 'Master', 'PhD']),
            'university'       => $this->faker->company . ' University',
            'field_of_study'   => $this->faker->word,
            'english'          => $this->faker->randomElement($levels),
            'another_lang'     => $this->faker->randomElement(array_diff($languages, ['German'])),
            'another_level'    => $this->faker->randomElement($levels),
            'experience'       => $this->faker->sentence(8),
            'shift_work'       => $this->faker->boolean,
            'salary'           => $this->faker->numberBetween(5000, 120000),
            'cv_pl'            => $this->faker->url,
            'cv_gb'            => $this->faker->url,
            'status'           => $this->faker->randomElement(['new', 'reviewed', 'interviewed', 'hired', 'rejected']),
            'english_rating'   => $this->faker->randomElement($levels),
            'sent_to'          => $this->faker->email,
            'interview'        => $this->faker->optional()->sentence(),
            'feedback'         => $this->faker->optional()->sentence(),
            'gender'           => $this->faker->randomElement(['male', 'female']),
            'gross'            => $this->faker->randomElement(['brutto', 'netto']),
            'notes'            => $this->faker->sentence(12),
        ];
    }
}
