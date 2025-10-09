<?php

namespace App\Livewire;

use \Livewire\TemporaryUploadedFile;
use App\Models\Applicant;
use App\Models\JobPosition;
use Illuminate\Support\Facades\Storage;       // filesystem helper
use Illuminate\Support\Str;                   // for random filenames
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class ApplicantFormComponent extends Component
{

    use WithFileUploads;                       // ← enables $this->cv_gb handling


    // ---------- właściwości formularza ----------
    public $firstname;
    public $lastname;
    public $new_consent_label;
    public $city;
    public $phone;
    public $email;
    public $job_position_id;
    public $education;
    public $university;
    public $field_of_study;
    public $english;
    public $another_lang;
    public $shift_work = false;
    public $selected_job_positions = [];   // <-- przechowuje zaznaczone ID‑y

    /** @var \Illuminate\Support\Collection */
    public $jobPositions;                  // lista wszystkich pozycji (do wyświetlenia)

    public $cv_pl;
    public $cv_gb;                               // holds the temporary upload


    // ---------- reguły walidacji ----------
    protected function rules(): array
    {
        return [
            'firstname'          => ['required', 'string', 'max:30'],
            'lastname'           => ['required', 'string', 'max:30'],
            'city'               => ['nullable', 'string', 'max:30'],
            'phone'              => ['nullable', 'string', 'max:30'],
            'email'              => ['nullable', 'email', 'max:50'],
            // 'job_position_id'    => ['nullable', 'exists:job_positions,id'],
            // 'education'          => ['required', 'string', 'max:30'],
            // 'university'         => ['required', 'string', 'max:191'],
            // 'field_of_study'     => ['required', 'string', 'max:191'],
            // 'english'            => ['required'],
            // 'another_lang'       => ['nullable', 'string', 'max:191'],
            'shift_work'         => ['required', 'boolean'],

            'selected_job_positions.*'=> ['integer', Rule::exists('job_positions', 'id')],
            // opcjonalnie wymóg przynajmniej jednego zaznaczenia:
            'selected_job_positions'   => ['array', 'min:1'],

            'cv_pl' => [
                'file',
                'max:512',                                 // 512 KB (Livewire works in kilobytes)
                'mimes:pdf,doc,docx,odt',                  // allowed extensions
            ],

            'cv_gb' => [
                'required',
                'file',
                'max:512',                                 // 512 KB (Livewire works in kilobytes)
                'mimes:pdf,doc,docx,odt',                  // allowed extensions
            ],
        ];
    }

    // ---------- akcje ----------
    public function submit()
    {
        $this->validate();

        $ulid = (string) Str::ulid(); 
        
        $extensionPl = $this->cv_pl->getClientOriginalExtension();
        $extensionGb = $this->cv_gb->getClientOriginalExtension();  
        
        $fileNamePl  = $ulid . '.' . $extensionPl;
        $fileNameGb  = $ulid . '.' . $extensionGb;
        
        $this->cv_pl->storeAs('pl', $fileNamePl, 'local');       // 'local' points to storage/app, which is not publicly accessible
        $this->cv_gb->storeAs('gb', $fileNameGb, 'local');       // 'local' points to storage/app, which is not publicly accessible
            // $this->cv_gb->storeAs(
            //     directory: 'gb',                               // podkatalog w storage/app
            //     path: $storedFileName,                         // nasza losowa nazwa z rozszerzeniem
            //     disk: 'local',                                 // domyślny dysk → storage/app
            //     visibility: 'private'                          // plik niewidoczny publicznie
            // );
        $dbPathPl = 'pl/' . $fileNamePl;
        $dbPathGb = 'gb/' . $fileNameGb; 

        // zapisujemy kandydata
        $applicant = Applicant::create([
            'firstname'           => $this->firstname,
            'lastname'            => $this->lastname,
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
        
        // ---- FILE columns (match your DB schema) ----
            'cv_pl'              => $dbPathPl,     
            'orig_filename_pl'    => $this->cv_pl->getClientOriginalName(),

            'cv_gb'               => $dbPathGb,                     // stored random name
            'orig_filename_gb'    => $this->cv_gb->getClientOriginalName(),
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
            'city',
            'phone',
            'email',
            'job_position_id',
            // 'education',
            // 'university',
            // 'field_of_study',
            // 'english',
            'shift_work',
            'selected_job_positions',
            'cv_pl',                         // clear temporary upload reference
            'cv_gb',                         // clear temporary upload reference
        ]);
    }

    public function render()
    {

        return view('livewire.applicant-form');
            //
    }

    public function mount()
    {
        // Pobieramy tylko potrzebne kolumny, aby nie obciążać pamięci
        $this->jobPositions = JobPosition::orderBy('name')->get(['id', 'name']);
    }


}
