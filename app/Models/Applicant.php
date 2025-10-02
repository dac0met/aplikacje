<?php

namespace App\Models;

use App\Models\JobPosition;
use App\Models\ConsentSource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'name',
        'surname',
        'yob',
        'city',
        'phone',
        'email',
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

    // protected static function booted()
    // {
    //     static::creating(function ($applicant) {
    //         \Log::debug('Applicant data before save', $applicant->attributesToArray());
    //     });
    // }
    
}
