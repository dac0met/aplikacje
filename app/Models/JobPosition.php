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
