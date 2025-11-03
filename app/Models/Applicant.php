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
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        $this->encryptedAttributes = ['firstname', 'lastname', 'name', 'email', 'phone'];
        $this->searchableAttributes = ['firstname', 'lastname', 'name', 'email', 'phone'];
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

    public function getEmailAttribute($value)
    {
        return $this->getDecryptedAttribute('email');
    }

    public function getPhoneAttribute($value)
    {
        return $this->getDecryptedAttribute('phone');
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

        $normalized = static::normalizeTextForSearchStatic($searchText);
        if (strlen($normalized) < 3) {
            return $query; // nie filtrujemy poniżej 3 znaków
        }

        $prefixLen = min(7, strlen($normalized));
        $prefix = substr($normalized, 0, $prefixLen);
        $hash = static::generateSearchHashStatic($prefix);

        return $query->whereHas('searchHashes', function ($q) use ($hash) {
            $q->where('field', 'firstname')->where('hash', $hash);
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

        $normalized = static::normalizeTextForSearchStatic($searchText);
        if (strlen($normalized) < 3) {
            return $query; // nie filtrujemy poniżej 3 znaków
        }

        $prefixLen = min(7, strlen($normalized));
        $prefix = substr($normalized, 0, $prefixLen);
        $hash = static::generateSearchHashStatic($prefix);

        return $query->whereHas('searchHashes', function ($q) use ($hash) {
            $q->where('field', 'lastname')->where('hash', $hash);
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

        $normalized = static::normalizeTextForSearchStatic($searchText);
        if (strlen($normalized) < 3) {
            return $query; // nie filtrujemy poniżej 3 znaków
        }

        $prefixLen = min(7, strlen($normalized));
        $prefix = substr($normalized, 0, $prefixLen);
        $hash = static::generateSearchHashStatic($prefix);

        return $query->where(function ($q) use ($hash) {
            $q->whereHas('searchHashes', fn ($qq) => $qq->where('field', 'firstname')->where('hash', $hash))
              ->orWhereHas('searchHashes', fn ($qq) => $qq->where('field', 'lastname')->where('hash', $hash))
              ->orWhereHas('searchHashes', fn ($qq) => $qq->where('field', 'name')->where('hash', $hash));
        });
    }

    public function scopeSearchByEmail($query, $searchText)
    {
        if (empty($searchText)) {
            return $query;
        }

        $normalized = static::normalizeTextForSearchStatic($searchText);
        if (strlen($normalized) < 3) {
            return $query;
        }

        $prefixLen = min(7, strlen($normalized));
        $prefix = substr($normalized, 0, $prefixLen);
        $hash = static::generateSearchHashStatic($prefix);

        return $query->whereHas('searchHashes', function ($q) use ($hash) {
            $q->where('field', 'email')->where('hash', $hash);
        });
    }

    public function scopeSearchByPhone($query, $searchText)
    {
        if (empty($searchText)) {
            return $query;
        }

        $normalized = static::normalizeTextForSearchStatic($searchText);
        if (strlen($normalized) < 3) {
            return $query;
        }

        $prefixLen = min(7, strlen($normalized));
        $prefix = substr($normalized, 0, $prefixLen);
        $hash = static::generateSearchHashStatic($prefix);

        return $query->whereHas('searchHashes', function ($q) use ($hash) {
            $q->where('field', 'phone')->where('hash', $hash);
        });
    }

    protected static function booted()
    {
        static::created(function (self $applicant) {
            $applicant->syncSearchHashes();
        });

        static::updated(function (self $applicant) {
            $applicant->syncSearchHashes();
        });
    }

    public function searchHashes(): HasMany
    {
        return $this->hasMany(\App\Models\ApplicantSearchHash::class);
    }

    protected function syncSearchHashes(): void
    {
        $fields = [
            'firstname' => $this->firstname ?? null,
            'lastname'  => $this->lastname ?? null,
            'name'      => $this->name ?? trim(($this->firstname ?? '') . ' ' . ($this->lastname ?? '')),
            'email'     => $this->email ?? null,
            'phone'     => $this->phone ?? null,
        ];

        foreach ($fields as $field => $value) {
            $this->searchHashes()->where('field', $field)->delete();

            if (empty($value)) {
                continue;
            }

            $hashes = static::generatePartialSearchHashesStatic($value);
            if (empty($hashes)) {
                continue;
            }

            $rows = array_map(function ($hash) use ($field) {
                return [
                    'field' => $field,
                    'hash'  => $hash,
                ];
            }, $hashes);

            $this->searchHashes()->createMany($rows);
        }
    }

}