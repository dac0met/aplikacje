<?php

use App\Models\Applicant;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ApplicantDownloadController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', HomeController::class)->name('home');

// Download CV with original filename (signed + auth + policy)
Route::middleware(['auth'])->group(function () {
    Route::get('/applicants/{applicant}/cv-gb', [ApplicantDownloadController::class, 'gb'])
        ->middleware(['signed','can:viewCv,applicant'])
        ->name('applicants.download.cv_gb');

    Route::get('/applicants/{applicant}/cv-pl', [ApplicantDownloadController::class, 'pl'])
        ->middleware(['signed','can:viewCv,applicant'])
        ->name('applicants.download.cv_pl');
});


Route::get('/applicant/confirm/{applicant}', function (Applicant $applicant) {
    // Sprawdzamy podpisany URL – Laravel automatycznie odrzuca nieprawidłowe/wygaśnięte
    if (!request()->hasValidSignature()) {
        abort(403, 'Nieprawidłowy lub wygasły link.');
    }

    // Aktualizujemy rekord, jeśli jeszcze nie został potwierdzony
    if (!$applicant->confirmation) {
        $applicant->update([
            'confirmation' => true,
        ]);
    }

    // Wyświetlamy prostą stronę potwierdzającą
    return view('applicant.confirmation');
})->name('applicants.confirm');
