<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicantDownloadController extends Controller
{
    public function gb(Applicant $applicant)
    {
        if (!$applicant->cv_gb || !Storage::disk('local')->exists($applicant->cv_gb)) {
            abort(404);
        }

        $path = $applicant->cv_gb;                         // e.g. "gb/filename.ext"
        $name = $applicant->orig_filename_gb ?: 'plik';

        $absolutePath = Storage::disk('local')->path($path);

        $response = response()->download($absolutePath, $name);
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        return $response;
    }

    public function pl(Applicant $applicant)
    {
        if (!$applicant->cv_pl || !Storage::disk('local')->exists($applicant->cv_pl)) {
            abort(404);
        }

        $path = $applicant->cv_pl;                         // e.g. "pl/filename.ext"
        $name = $applicant->orig_filename_pl ?: 'plik';

        $absolutePath = Storage::disk('local')->path($path);

        $response = response()->download($absolutePath, $name);
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        return $response;
    }
}


