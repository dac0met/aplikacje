<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Applicant;
use App\Models\ConsentSource;
use App\Models\JobPosition;
use Illuminate\Validation\Rule;

class ApplicantFormComponent extends Component
{
    // ---------- właściwości formularza ----------
    public $firstname;
    public $lastname;
    public $yob;
    public $new_consent_label;
    public $city;
    public $phone;
    public $email;
    public $job_position_id;
    public $education;
    public $university;
    public $field_of_study;
    public $english;
    public $shift_work = false;

    public $selected_job_positions = [];   // <-- przechowuje zaznaczone ID‑y

    /** @var \Illuminate\Support\Collection */
    public $jobPositions;                  // lista wszystkich pozycji (do wyświetlenia)

    // ---------- reguły walidacji ----------
    protected function rules(): array
    {
        return [
            'firstname'               => ['required', 'string', 'max:30'],
            'lastname'            => ['required', 'string', 'max:30'],
            'yob'                => ['nullable', 'digits:4'],
            'city'               => ['nullable', 'string', 'max:30'],
            'phone'              => ['nullable', 'string', 'max:30'],
            'email'              => ['nullable', 'email', 'max:50'],
            'job_position_id'    => ['nullable', 'exists:job_positions,id'],
            // 'education'          => ['required', 'string', 'max:30'],
            // 'university'         => ['required', 'string', 'max:191'],
            // 'field_of_study'     => ['required', 'string', 'max:191'],
            // 'english'            => ['required'],
            // 'another_lang'       => ['nullable', 'string', 'max:191'],
            'shift_work'         => ['required', 'boolean'],

            'selected_job_positions.*'=> ['integer', Rule::exists('job_positions', 'id')],
            // opcjonalnie wymóg przynajmniej jednego zaznaczenia:
            'selected_job_positions'   => ['array', 'min:1'],
        ];
    }

    // ---------- akcje ----------
    public function submit()
    {
        $this->validate();

        // zapisujemy kandydata
        $applicant = Applicant::create([
            'firstname'               => $this->firstname,
            'lastname'            => $this->lastname,
            'yob'                => $this->yob,
            'city'               => $this->city,
            'phone'              => $this->phone,
            'email'              => $this->email,
            'job_position_id'    => $this->job_position_id,
            // 'education'          => $this->education,
            // 'university'         => $this->university,
            // 'field_of_study'     => $this->field_of_study,
            // 'english'            => $this->english,
            // 'another_lang'       => $this->another_lang,
            'shift_work'         => $this->shift_work,
        ]);

        // Relacja many‑to‑many (zakładamy, że istnieje pivot candidate_job_position)
        $applicant->jobPositions()->sync($this->selected_job_positions);

        session()->flash('message', 'Formularz został pomyślnie wysłany.');
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->reset([
            'firstname',
            'lastname',
            'yob',
            'city',
            'phone',
            'email',
            'job_position_id',
            // 'education',
            // 'university',
            // 'field_of_study',
            // 'english',
            'shift_work',
        ]);
    }

    public function render()
    {

        return view('livewire.applicant-form');

        // return view('livewire.applicant-form', [
        //         // 'consentSources' => ConsentSource::orderBy('label')->pluck('label', 'id'),
        //     'jobPositions'   => JobPosition::orderBy('name')->pluck('name', 'id'),
        // ]);
    }

    public function mount()
    {
        // Pobieramy tylko potrzebne kolumny, aby nie obciążać pamięci
        $this->jobPositions = JobPosition::orderBy('name')->get(['id', 'name']);
    }


}
