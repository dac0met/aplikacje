<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Applicant;

class ApplicantPolicy
{
    public function viewCv(User $user, Applicant $applicant): bool
    {
        // Example: only users with roles admin/manager can download CVs.
        if (method_exists($user, 'hasAnyRole')) {
            return $user->hasAnyRole(['admin','manager']);
        }

        // Fallback: allow authenticated users (adjust to your needs)
        return true;
    }
}


