<?php

namespace App\Models;

use App\Models\ConsentSource;
use App\Models\JobPosition;
use App\Traits\EncryptsAttributes;
use App\Traits\GeneratesSearchHashes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
// use Illuminate\Database\Eloquent\Concerns\HasRelationships;

class Applicant extends Model
{
    use HasFactory, EncryptsAttributes, GeneratesSearchHashes; // HasRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'consent_source_id',
        'submitted_date',
        'user_ip',
        'confirmation',
        'firstname',
        'lastname',
        'name',
        'firstname_search_hashes',
        'lastname_search_hashes',
        'name_search_hashes',
        'yob',
        'city',
        'phone',
        'email',
        'position',
        'consent',
        'education',
        'university',
        'field_of_study',
        'english',
        'another_lang',
        'another_level',
        'experience',
        'shift_work',
        'salary',
        'cv_pl',
        'cv_gb',
        'orig_filename_pl',
        'orig_filename_gb',
        'status',
        'english_rating',
        'info',
        'sent_to',
        'interview',
        'feedback',
        'gender',
        'gross',
        'notes',

    ];

    /**
     * Konstruktor - ustawia atrybuty do szyfrowania
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->encryptedAttributes = ['firstname', 'lastname', 'name'];
        $this->searchableAttributes = ['firstname', 'lastname', 'name'];
    }

    public function consentSource() : BelongsTo
    {
        return $this->belongsTo(ConsentSource::class);
    }

    public function jobPosition() : BelongsTo
    {
        return $this->belongsTo(JobPosition::class);
    }

    public function jobPositions() : BelongsToMany     // na frondendzie
    {
        return $this->belongsToMany(JobPosition::class,
            'applicant_job_position',   // nazwa tabeli pivot
            'applicant_id',
            'job_position_id');
    }

    /** @return string */
    public function getPositionsAttribute(): string
    {
        return $this->jobPositions
            ->pluck('name')
            ->join("\n");       // nowa linia – idealna dla Textarea
    }

    /**
     * Mutator dla firstname - automatycznie generuje hash wyszukiwania
     */
    public function setFirstnameAttribute($value)
    {
        $this->attributes['firstname'] = $value;
        if (!empty($value)) {
            $hashes = $this->generatePartialSearchHashes($value);
            $this->attributes['firstname_search_hashes'] = $this->hashesToString($hashes);
        } else {
            $this->attributes['firstname_search_hashes'] = null;
        }
        
        // Aktualizujemy pole name i jego hash
        $this->updateNameAndHashes();
    }

    /**
     * Mutator dla lastname - automatycznie generuje hash wyszukiwania
     */
    public function setLastnameAttribute($value)
    {
        $this->attributes['lastname'] = $value;
        if (!empty($value)) {
            $hashes = $this->generatePartialSearchHashes($value);
            $this->attributes['lastname_search_hashes'] = $this->hashesToString($hashes);
        } else {
            $this->attributes['lastname_search_hashes'] = null;
        }
        
        // Aktualizujemy pole name i jego hash
        $this->updateNameAndHashes();
    }

    /**
     * Mutator dla name - automatycznie generuje hash wyszukiwania
     */
    public function setNameAttribute($value)
    {
        // Zapisujemy wartość name do bazy danych
        $this->attributes['name'] = $value;
        
        // Generujemy hash dla wyszukiwania
        if (!empty($value)) {
            $hashes = $this->generatePartialSearchHashes($value);
            $this->attributes['name_search_hashes'] = $this->hashesToString($hashes);
        } else {
            $this->attributes['name_search_hashes'] = null;
        }
    }

    /**
     * Aktualizuje pole name i jego hash na podstawie firstname i lastname
     */
    protected function updateNameAndHashes()
    {
        $firstname = $this->attributes['firstname'] ?? '';
        $lastname = $this->attributes['lastname'] ?? '';
        
        if (!empty($firstname) || !empty($lastname)) {
            $fullName = trim($firstname . ' ' . $lastname);
            
            // Zapisujemy pełne imię i nazwisko do pola name
            $this->attributes['name'] = $fullName;
            
            // Generujemy hash dla wyszukiwania
            $hashes = $this->generatePartialSearchHashes($fullName);
            $this->attributes['name_search_hashes'] = $this->hashesToString($hashes);
        } else {
            $this->attributes['name'] = null;
            $this->attributes['name_search_hashes'] = null;
        }
    }

    /**
     * Accessor dla firstname - zwraca zdeszyfrowaną wartość
     */
    public function getFirstnameAttribute($value)
    {
        return $this->getDecryptedAttribute('firstname');
    }

    /**
     * Accessor dla lastname - zwraca zdeszyfrowaną wartość
     */
    public function getLastnameAttribute($value)
    {
        return $this->getDecryptedAttribute('lastname');
    }

    /**
     * Accessor dla name - zwraca połączone imię i nazwisko
     */
    public function getNameAttribute($value)
    {
        // Jeśli pole name jest zaszyfrowane, deszyfrujemy je
        if (!empty($value)) {
            try {
                return $this->getDecryptedAttribute('name');
            } catch (\Exception $e) {
                // Jeśli deszyfrowanie się nie powiedzie, zwracamy oryginalną wartość
                return $value;
            }
        }
        
        // Jeśli pole name jest puste, generujemy je z firstname i lastname
        $firstname = $this->getDecryptedAttribute('firstname');
        $lastname = $this->getDecryptedAttribute('lastname');
        
        return trim($firstname . ' ' . $lastname);
    }

    /**
     * Scope do wyszukiwania po imieniu
     */
    public function scopeSearchByFirstname($query, $searchText)
    {
        if (empty($searchText)) {
            return $query;
        }

        $searchHashes = static::generatePartialSearchHashesStatic($searchText);
        
        return $query->where(function ($q) use ($searchHashes) {
            foreach ($searchHashes as $hash) {
                $q->orWhere('firstname_search_hashes', 'LIKE', '%' . $hash . '%');
            }
        });
    }

    /**
     * Scope do wyszukiwania po nazwisku
     */
    public function scopeSearchByLastname($query, $searchText)
    {
        if (empty($searchText)) {
            return $query;
        }

        $searchHashes = static::generatePartialSearchHashesStatic($searchText);
        
        return $query->where(function ($q) use ($searchHashes) {
            foreach ($searchHashes as $hash) {
                $q->orWhere('lastname_search_hashes', 'LIKE', '%' . $hash . '%');
            }
        });
    }

    /**
     * Scope do wyszukiwania po imieniu i nazwisku
     */
    public function scopeSearchByName($query, $searchText)
    {
        if (empty($searchText)) {
            return $query;
        }

        $searchHashes = static::generatePartialSearchHashesStatic($searchText);
        
        return $query->where(function ($q) use ($searchHashes) {
            foreach ($searchHashes as $hash) {
                $q->orWhere('firstname_search_hashes', 'LIKE', '%' . $hash . '%')
                  ->orWhere('lastname_search_hashes', 'LIKE', '%' . $hash . '%')
                  ->orWhere('name_search_hashes', 'LIKE', '%' . $hash . '%');
            }
        });
    }

    /**
     * Metoda testowa do debugowania hash wyszukiwania
     */
    public static function testSearchHashes($searchText)
    {
        $applicant = new self();
        $hashes = $applicant->generatePartialSearchHashes($searchText);
        
        \Log::info("Test search for: '{$searchText}'");
        \Log::info("Generated hashes: " . implode(', ', $hashes));
        
        // Sprawdźmy czy istnieją rekordy z tymi hash
        $query = self::query();
        foreach ($hashes as $hash) {
            $query->orWhere('firstname_search_hashes', 'LIKE', '%' . $hash . '%')
                  ->orWhere('lastname_search_hashes', 'LIKE', '%' . $hash . '%');
        }
        
        $results = $query->get();
        \Log::info("Found {$results->count()} results");
        
        return [
            'search_text' => $searchText,
            'hashes' => $hashes,
            'results_count' => $results->count(),
            'results' => $results->pluck('id')->toArray()
        ];
    }

    // protected static function booted()
    // {
    //     static::creating(function ($applicant) {
    //         \Log::debug('Applicant data before save', $applicant->attributesToArray());
    //     });
    // }

}