<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicantSearchHash extends Model
{
    use HasFactory;

    protected $table = 'applicant_search_hashes';

    protected $fillable = [
        'applicant_id',
        'field',
        'hash',
    ];

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }
}