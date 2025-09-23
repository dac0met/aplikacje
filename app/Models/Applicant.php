<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'submission_id',
        'job_position_id',
        'submitted_date',
        'user_ip',
        'name',
        'surname',
        'yob',
        'city',
        'phone',
        'email',
        'consent',
        'job_position',
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
        'status',
        'english_rating',
        'info',
        'sent_to',
        'interview',
        'feedback',
        'gender',
        'gross',
        'consent_source',
        'notes',
    ];

    
}
