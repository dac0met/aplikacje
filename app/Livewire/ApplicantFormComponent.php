<?php

namespace App\Livewire;

use Log;
use Livewire\Component;
use App\Models\Applicant;
use App\Models\JobPosition;
use Livewire\WithFileUploads;
use App\Mail\ApplicantConfirmationMail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;                   // for random filenames
use Illuminate\Support\Facades\Validator;     // for pre-submit check


class ApplicantFormComponent extends Component
{

    use WithFileUploads;                       // ← enables $this->cv_gb handling

    public $showModal = false;   // steruje widocznością modala (sukces)
    public $showMissingModal = false; // steruje widocznością modala (brakujące pola)
    public array $missingFields = []; // lista brakujących pól

    // ---------- właściwości formularza ----------
    public string $firstname = '';
    public string $lastname = '';
    public $new_consent_label;
    public string $city = '';
    public $phone;
    public string $email = '';
    public $job_position_id;
    public string $education = '';
    public string $university = '';
    public string $field_of_study = '';
    public string $experience = '';
    public string $english = '';
    public string $another_lang = '';
    public string $another_level = '';
    public $shift_work = null;
    public ?int $salary = null;
    public $selected_job_positions = [];            // <-- przechowuje zaznaczone ID‑y
    public $consent = false;
    public $rodo = false;   // checkbox RODO nic nie zapisuje w bazie danych, uaktywnia przycisk submit, jest zerowany
    public Collection $jobPositions;                // lista wszystkich pozycji (do wyświetlenia)
    public $cv_pl;
    public $cv_gb;                               // holds the temporary upload
    public int $fileInputKey = 0;                // forces file input DOM reset
    public int $formKey = 0;                     // forces whole form re-render

    public int $maxPositions = 3;                // maksymalna liczba pozycji do wyboru
    public bool $tooManyPositions = false;       // flaga do komunikatu w UI

    public int $consent_source_id;

    // Honeypot
    public $website; // boty często wypełniają takie pole

    // Captcha
    public $captchaQuestion;
    public $captchaAnswer;
    public $expectedAnswer;


    // ---------- reguły walidacji ----------
    protected function rules(): array
    {
        return [
            'firstname'          => ['required', 'string', 'max:30'],
            'lastname'           => ['required', 'string', 'max:30'],
            'city'               => ['required', 'string', 'max:30'],
            'phone'              => ['nullable', 'string', 'max:30'],
            'email'              => ['required', 'email', 'max:50'],
            'job_position_id'    => ['nullable', 'exists:job_positions,id'],
            'education'          => ['required', 'string', 'max:30'],
            'university'         => ['required', 'string', 'max:191'],
            'field_of_study'     => ['required', 'string', 'max:191'],
            'experience'        => ['required', 'string'],
            'english'            => ['required', 'string', 'max:2'],
            'another_lang'       => ['nullable', 'string', 'max:30'],
            'another_level'      => ['nullable', 'string', 'max:2'],
            'shift_work'         => ['required', 'string', 'in:0,1'],
            'salary'            => ['nullable', 'numeric'],
            'consent'         => ['required', 'string', 'in:current,future'],

            'selected_job_positions.*'=> ['integer', Rule::exists('job_positions', 'id')],
            'selected_job_positions'   => ['array', 'min:1', 'max:3'],   // opcjonalnie wymóg przynajmniej jednego zaznaczenia:

            'cv_pl' => [
                'nullable',
                'file',
                'max:640',                                 // 512 KB (Livewire works in kilobytes)
                'mimes:pdf,doc,docx,odt',                  // allowed extensions
            ],

            'cv_gb' => [
                'required',
                'file',
                'max:640',                                 // 512 KB (Livewire works in kilobytes)
                'mimes:pdf,doc,docx,odt',                  // allowed extensions
            ],

            'captchaAnswer' => 'required|numeric',
        ];
    }


    // ---------- pre‑submit: pokaż modal z brakującymi polami ----------
    public function preSubmit(): void
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->missingFields = [];

        $data = [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'city' => $this->city,
            'phone' => $this->phone,
            'email' => $this->email,
            'job_position_id' => $this->job_position_id,
            'education' => $this->education,
            'university' => $this->university,
            'field_of_study' => $this->field_of_study,
            'experience' => $this->experience,
            'english' => $this->english,
            'another_lang' => $this->another_lang,
            'another_level' => $this->another_level,
            'shift_work' => $this->shift_work,
            'salary' => $this->salary,
            'consent' => $this->consent,
            'selected_job_positions' => $this->selected_job_positions,
            'cv_pl' => $this->cv_pl,
            'cv_gb' => $this->cv_gb,
            'captchaAnswer' => $this->captchaAnswer,
        ];

        $validator = Validator::make($data, $this->rules());

        if ($validator->fails()) {
            $labels = [
                'firstname' => 'First name',
                'lastname' => 'Last name',
                'city' => 'Place of residence (City)',
                'email' => 'Email address',
                'education' => 'Education',
                'university' => 'University',
                'field_of_study' => 'Field of Study',
                'experience' => 'Experience',
                'english' => 'Level of English',
                'shift_work' => 'Willingness to work in shifts',
                'consent' => 'Consent option',
                'selected_job_positions' => 'Position applied for',
                'cv_gb' => 'Resume in English',
                'captchaAnswer' => 'Captcha answer',
            ];

            // Sprawdzamy tylko pola wymagane (nieuzupełnione)
            foreach ($labels as $field => $label) {
                $valueMissing = false;
                if ($field === 'selected_job_positions') {
                    $valueMissing = empty($this->selected_job_positions);
                } elseif ($field === 'shift_work') {
                    $valueMissing = $this->shift_work === null || $this->shift_work === '';
                } elseif ($field === 'cv_gb') {
                    $valueMissing = empty($this->cv_gb);
                } else {
                    $val = $this->$field ?? null;
                    $valueMissing = ($val === null || $val === '');
                }

                if ($valueMissing && $validator->errors()->has($field)) {
                    $this->missingFields[] = $label;
                }
            }
        }

        if (!empty($this->missingFields)) {
            $this->showMissingModal = true;
            return; // nie wysyłamy formularza
        }

        // brak braków – kontynuujemy standardowe submit
        $this->submit();
    }

    public function closeMissingModal(): void
    {
        $this->showMissingModal = false;
    }


    // ---------- akcje ----------
    public function submit()
    {
        $this->validate();

        $consent_source_id = 1;         // źródło zgody pochodzi z formularza firmowego

        $dbPathPl = null;
        $origFilenamePl = null;
        $ulid = (string) Str::ulid();

        // cv_pl nie jest wymagane
        if ($this->cv_pl)
        {
            $extensionPl = $this->cv_pl->getClientOriginalExtension();
            $fileNamePl  = $ulid . '.' . $extensionPl;
            $this->cv_pl->storeAs('pl', $fileNamePl, 'local');

            $dbPathPl = 'pl/' . $fileNamePl;
            $origFilenamePl = $this->cv_pl->getClientOriginalName();
        }

        $extensionGb = $this->cv_gb->getClientOriginalExtension();
        $fileNameGb  = $ulid . '.' . $extensionGb;
        $this->cv_gb->storeAs('gb', $fileNameGb, 'local');
        $dbPathGb = 'gb/' . $fileNameGb;
        $origFilenameGb = $this->cv_gb->getClientOriginalName();

        // Sprawdzenie honeypot
        if (!empty($this->website)) {
            // Bot – przerywamy
            return back()->withErrors(['error' => 'Spam detected.']);
        }

        // Sprawdzenie captcha
        if ((int)$this->captchaAnswer !== $this->expectedAnswer) {
            $this->addError('captchaAnswer', 'Niepoprawna odpowiedź.');
            $this->generateCaptcha();
            return;
        }

        // zapisujemy kandydata
        $applicant = Applicant::create([
            'firstname'           => $this->firstname,
            'lastname'            => $this->lastname,
            'city'               => $this->city,
            'phone'              => $this->phone,
            'email'              => $this->email,
            // 'user_ip'            => inet_ntop(inet_pton(request()->ip())) ?: request()->ip(),
            'user_ip' => filter_var(request()->ip(), FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ?: '127.0.0.1',
            'job_position_id'    => $this->job_position_id,
            'education'          => $this->education,
            'university'         => $this->university,
            'field_of_study'     => $this->field_of_study,
            'experience'         => $this->experience,
            'english'            => $this->english,
            'another_lang'       => $this->another_lang,
            'another_level'      => $this->another_level,
            'shift_work'         => $this->shift_work,
            'salary'             => $this->salary,
            'consent'            => $this->consent,
            'cv_pl'              => $dbPathPl,
            'orig_filename_pl'    =>$origFilenamePl,

            'cv_gb'               => $dbPathGb,
            'orig_filename_gb'    =>$origFilenameGb,
            'submitted_date'      => now(),
            'consent_source_id'   =>$consent_source_id,

        ]);


        // Relacja many‑to‑many (zakładamy, że istnieje pivot applicant_job_position)
        $applicant->jobPositions()->sync($this->selected_job_positions);

        // Wysyłamy maila (asynchronicznie, jeśli masz kolejkę)
        Mail::to($applicant->email)->queue(new ApplicantConfirmationMail($applicant));


        // Pokazujemy modal
        $this->showModal = true;

        $this->resetForm();  // resetuje formularz

        $this->generateCaptcha();

    }

    private function resetForm(): void
    {
        // Usuń wszystkie komunikaty o błędach i informacje walidacyjne
        $this->resetErrorBag();
        $this->resetValidation();

        $this->reset([
            'firstname',
            'lastname',
            'city',
            'phone',
            'email',
            'job_position_id',
            'selected_job_positions',
            'education',
            'university',
            'field_of_study',
            'experience',
            'english',
            'another_lang',
            'another_level',
            'shift_work',
            'salary',
            'consent',
            'rodo',
            'cv_pl',                         // clear temporary upload reference
            'cv_gb',                         // clear temporary upload reference
            'captchaAnswer',
        ]);

        //  $this->shift_work = false;
         $this->fileInputKey++;              // re-render file inputs
         $this->formKey++;                   // re-render whole form to beat autofill
    }

    public function render()
    {
        return view('livewire.applicant-form');
    }

    public function updated($name): void
    {
        if (Str::startsWith($name, 'selected_job_positions')) {
            $this->enforceMaxPositions();
        }
    }

    public function enforceMaxPositions(): void
    {
        $arr = $this->selected_job_positions ?? [];
        if (!is_array($arr)) {
            $arr = [];
        }
        if (count($arr) > $this->maxPositions) {
            $this->selected_job_positions = array_slice($arr, 0, $this->maxPositions);
            $this->tooManyPositions = true;
        } else {
            $this->tooManyPositions = false;
        }
    }

    public function mount()
    {
        // Pobieramy tylko potrzebne kolumny, aby nie obciążać pamięci
        $this->jobPositions = JobPosition::where('published', 1)->orderBy('name')->get(['id', 'name']);
        $this->generateCaptcha();
    }

    public function generateCaptcha()
    {
        $a = rand(1, 9);
        $b = rand(1, 9);
        $this->captchaQuestion = "Enter the result of the operation below: $a + $b?";
        $this->expectedAnswer = $a + $b;
    }

    public function getSelectedCountProperty(): int
    {
        return is_array($this->selected_job_positions) ? count($this->selected_job_positions) : 0;
    }
}
