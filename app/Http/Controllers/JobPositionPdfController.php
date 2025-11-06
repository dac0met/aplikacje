<?php

namespace App\Http\Controllers;

use App\Models\JobPosition;
use Illuminate\Support\Facades\Storage;

class JobPositionPdfController extends Controller
{
    public function show(JobPosition $jobPosition)
    {
        $finalName = $jobPosition->filename ?: \Illuminate\Support\Str::of($jobPosition->name)->snake('_').'.pdf';
        if (!str_ends_with($finalName, '.pdf')) {
            $finalName .= '.pdf';
        }
        $relativePath = 'job_descriptions/'.$finalName;

        if (!Storage::disk('public')->exists($relativePath)) {
            abort(404);
        }

        $fullPath = Storage::disk('public')->path($relativePath);
        return response()->file($fullPath, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
