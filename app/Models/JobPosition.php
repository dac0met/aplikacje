<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class JobPosition extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'published',
        'filename',
        'contents',
        'lang',
        'looking_for_candidates',
        'location',
        'job_description',
        'key_responsibilities',
        'resp_items_text',
        'our_requirements',
        'req_items_text',
        'we_offer',
        'offer_items_text',
        'option2_title',
        'option1',
        'option2',
        'option3',

    ];

    public function applicants() : BelongsToMany     // na frondendzie
    {
        return $this->belongsToMany(Applicant::class,
            'applicant_job_position',   // tabela pośrednia
            'job_position_id',          // klucz obcy tej tabeli
            'applicant_id'              // klucz obcy tabeli docelowej
        );
    }
    
}
