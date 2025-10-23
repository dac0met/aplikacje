<?php

namespace App\Models;

use App\Models\ConsentSource;
use App\Models\JobPosition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
// use Illuminate\Database\Eloquent\Concerns\HasRelationships;

class Applicant extends Model
{
    use HasFactory; // HasRelationships;

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

    // protected static function booted()
    // {
    //     static::creating(function ($applicant) {
    //         \Log::debug('Applicant data before save', $applicant->attributesToArray());
    //     });
    // }

}