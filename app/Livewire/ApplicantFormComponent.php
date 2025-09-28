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
    public $name;
    public $surname;
    public $yob;
    public $new_consent_label;
    public $city;
    public $email;
    public $phone;
    public $job_position_id;
    public $shift_work = false;

    // kontrola widoczności modala
    public $showConsentModal = false;

    // ---------- reguły walidacji ----------
    protected function rules(): array
    {
        return [
            'name'               => ['required', 'string', 'max:191'],
            'surname'            => ['required', 'string', 'max:191'],
            'yob'                => ['nullable', 'digits:4'],
            'city'               => ['nullable', 'string', 'max:191'],
            'email'              => ['nullable', 'email', 'max:191'],
            'phone'              => ['nullable', 'string', 'max:30'],
            'job_position_id'    => ['nullable', 'exists:job_positions,id'],
            'shift_work'         => ['required', 'boolean'],
        ];
    }

    // ---------- akcje ----------
    public function submit()
    {
        $this->validate();

        // zapisujemy kandydata
        Applicant::create([
            'name'               => $this->name,
            'surname'            => $this->surname,
            'yob'                => $this->yob,
                // 'consent_source_id'  => $this->consent_source_id,
            'city'               => $this->city,
            'email'              => $this->email,
            'phone'              => $this->phone,
            'job_position_id'    => $this->job_position_id,
            'shift_work'         => $this->shift_work,
        ]);

        session()->flash('message', 'Formularz został pomyślnie wysłany.');
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->reset([
            'name',
            'surname',
            'yob',
            'city',
            'email',
            'phone',
            'job_position_id',
            'shift_work',
        ]);
    }

    public function render()
    {
        return view('livewire.applicant-form', [
                // 'consentSources' => ConsentSource::orderBy('label')->pluck('label', 'id'),
            'jobPositions'   => JobPosition::orderBy('name')->pluck('name', 'id'),
        ]);
    }
}
