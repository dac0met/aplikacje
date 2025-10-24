<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\ApplicantFormComponent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\UploadedFile;
use App\Models\JobPosition;
use App\Models\ConsentSource;

class ApplicantFormTest extends TestCase
{
    use RefreshDatabase;

    private function seedJobPositions(): array
    {
        $jp1 = JobPosition::create(['name' => 'Developer']);
        $jp2 = JobPosition::create(['name' => 'Designer']);
        return [$jp1->id, $jp2->id];
    }

    private function minimalValidPayload(): array
    {
        [$jp1, $jp2] = $this->seedJobPositions();

        // Ensure consent_sources has id=1 referenced by component
        ConsentSource::create(['name' => 'web']);

        Storage::fake('local');
        Mail::fake();

        return [
            'firstname' => 'Jan',
            'lastname' => 'Kowalski',
            'city' => 'Warszawa',
            'phone' => '123456789',
            'email' => 'jan@example.com',
            'job_position_id' => $jp1,
            'education' => 'Wyższe',
            'university' => 'PW',
            'field_of_study' => 'Informatyka',
            'experience' => '2 lata',
            'english' => 'B2',
            'another_lang' => '',
            'another_level' => '',
            'shift_work' => '0',
            'salary' => 10000,
            'consent' => 'current',
            'selected_job_positions' => [$jp1, $jp2],
            'cv_gb' => UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf'),
            'cv_pl' => null,
            'website' => '',
            'rodo' => true,
        ];
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_submits_form_with_correct_captcha_and_empty_honeypot()
    {
        $data = $this->minimalValidPayload();

        $component = Livewire::test(ApplicantFormComponent::class)
            ->set('firstname', $data['firstname'])
            ->set('lastname', $data['lastname'])
            ->set('city', $data['city'])
            ->set('phone', $data['phone'])
            ->set('email', $data['email'])
            ->set('job_position_id', $data['job_position_id'])
            ->set('education', $data['education'])
            ->set('university', $data['university'])
            ->set('field_of_study', $data['field_of_study'])
            ->set('experience', $data['experience'])
            ->set('english', $data['english'])
            ->set('another_lang', $data['another_lang'])
            ->set('another_level', $data['another_level'])
            ->set('shift_work', $data['shift_work'])
            ->set('salary', $data['salary'])
            ->set('consent', $data['consent'])
            ->set('selected_job_positions', $data['selected_job_positions'])
            ->set('cv_gb', $data['cv_gb'])
            ->set('cv_pl', $data['cv_pl'])
            ->set('website', $data['website'])
            ->set('rodo', $data['rodo']);

        $component->call('generateCaptcha');
        $expected = $component->get('expectedAnswer');

        $component
            ->set('captchaAnswer', $expected)
            ->call('submit')
            ->assertHasNoErrors();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_rejects_form_if_honeypot_filled()
    {
        $data = $this->minimalValidPayload();
        $data['website'] = 'spam-bot';

        $component = Livewire::test(ApplicantFormComponent::class)
            ->set('firstname', $data['firstname'])
            ->set('lastname', $data['lastname'])
            ->set('city', $data['city'])
            ->set('phone', $data['phone'])
            ->set('email', $data['email'])
            ->set('job_position_id', $data['job_position_id'])
            ->set('education', $data['education'])
            ->set('university', $data['university'])
            ->set('field_of_study', $data['field_of_study'])
            ->set('experience', $data['experience'])
            ->set('english', $data['english'])
            ->set('another_lang', $data['another_lang'])
            ->set('another_level', $data['another_level'])
            ->set('shift_work', $data['shift_work'])
            ->set('salary', $data['salary'])
            ->set('consent', $data['consent'])
            ->set('selected_job_positions', $data['selected_job_positions'])
            ->set('cv_gb', $data['cv_gb'])
            ->set('cv_pl', $data['cv_pl'])
            ->set('website', $data['website'])
            ->set('rodo', $data['rodo']);

        $component->call('generateCaptcha');
        $expected = $component->get('expectedAnswer');

        $component
            ->set('captchaAnswer', $expected)
            ->call('submit')
            ->assertSet('showModal', false);

        $this->assertDatabaseCount('applicants', 0);
        Mail::assertNothingQueued();

        $filesInGb = Storage::disk('local')->allFiles('gb');
        $this->assertGreaterThan(0, count($filesInGb));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_rejects_form_if_captcha_wrong()
    {
        $data = $this->minimalValidPayload();

        $component = Livewire::test(ApplicantFormComponent::class)
            ->set('firstname', $data['firstname'])
            ->set('lastname', $data['lastname'])
            ->set('city', $data['city'])
            ->set('phone', $data['phone'])
            ->set('email', $data['email'])
            ->set('job_position_id', $data['job_position_id'])
            ->set('education', $data['education'])
            ->set('university', $data['university'])
            ->set('field_of_study', $data['field_of_study'])
            ->set('experience', $data['experience'])
            ->set('english', $data['english'])
            ->set('another_lang', $data['another_lang'])
            ->set('another_level', $data['another_level'])
            ->set('shift_work', $data['shift_work'])
            ->set('salary', $data['salary'])
            ->set('consent', $data['consent'])
            ->set('selected_job_positions', $data['selected_job_positions'])
            ->set('cv_gb', $data['cv_gb'])
            ->set('cv_pl', $data['cv_pl'])
            ->set('website', $data['website'])
            ->set('rodo', $data['rodo']);

        $component->call('generateCaptcha');
        $expected = $component->get('expectedAnswer');

        $component
            ->set('captchaAnswer', 999)
            ->call('submit')
            ->assertHasErrors(['captchaAnswer']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_rejects_form_if_consent_not_set()
    {
        $data = $this->minimalValidPayload();
        $data['consent'] = '';

        $component = Livewire::test(ApplicantFormComponent::class)
            ->set('firstname', $data['firstname'])
            ->set('lastname', $data['lastname'])
            ->set('city', $data['city'])
            ->set('phone', $data['phone'])
            ->set('email', $data['email'])
            ->set('job_position_id', $data['job_position_id'])
            ->set('education', $data['education'])
            ->set('university', $data['university'])
            ->set('field_of_study', $data['field_of_study'])
            ->set('experience', $data['experience'])
            ->set('english', $data['english'])
            ->set('another_lang', $data['another_lang'])
            ->set('another_level', $data['another_level'])
            ->set('shift_work', $data['shift_work'])
            ->set('salary', $data['salary'])
            ->set('consent', $data['consent'])
            ->set('selected_job_positions', $data['selected_job_positions'])
            ->set('cv_gb', $data['cv_gb'])
            ->set('cv_pl', $data['cv_pl'])
            ->set('website', $data['website'])
            ->set('rodo', false);

        $component->call('generateCaptcha');
        $expected = $component->get('expectedAnswer');

        $component
            ->set('captchaAnswer', $expected)
            ->call('submit')
            ->assertHasErrors(['consent']);
    }
}
