<?php

namespace App\Services;

use App\Models\UserTablePreference;

class TablePreferences
{
    public function getVisibleColumns(?int $userId, string $tableKey): array
    {
        if (!$userId) {
            return $this->defaultVisibleFor($tableKey);
        }

        $pref = UserTablePreference::query()
            ->where('user_id', $userId)
            ->where('table_key', $tableKey)
            ->first();

        if ($pref && is_array($pref->visible_columns) && count($pref->visible_columns)) {
            return $pref->visible_columns;
        }

        return $this->defaultVisibleFor($tableKey);
    }

    public function saveVisibleColumns(?int $userId, string $tableKey, array $columns): void
    {
        if (!$userId) {
            return;
        }

        UserTablePreference::updateOrCreate(
            ['user_id' => $userId, 'table_key' => $tableKey],
            ['visible_columns' => array_values($columns)]
        );
    }

    private function defaultVisibleFor(string $tableKey): array
    {
        // Domyślny zestaw odpowiada kolumnom, które były widoczne bez preferencji
        // w aktualnym ApplicantsTable (te, które NIE były oznaczone jako hidden by default)
        if ($tableKey === 'admin.applicants') {
            return [
                'id',
                'confirmation',
                'firstname',
                'lastname',
                'consentsource.name',
                'email',
                'phone',
                'position',
                'education',
                'university',
                'field_of_study',
                'english',
                'english_rating',
                'another_lang',
                'another_level',
                'shift_work',
                'consent',
                'experience',
                'notes',
                'status',
                'sent_to',
            ];
        }

        if ($tableKey === 'editor.applicants') {
            return [
                'id',
                'firstname',
                'lastname',
                'consentsource.name',
                'email',
                'phone',
                'position',
                'education',
                'university',
                'field_of_study',
                'english',
                'english_rating',
                'another_lang',
                'another_level',
                'shift_work',
                'consent',
                'experience',
                'sent_to',
            ];
        }

        if ($tableKey === 'manager.applicants') {
            return [
                'id',
                'firstname',
                'lastname',
                'consentsource.name',
                'email',
                'phone',
                'position',
                'education',
                'university',
                'field_of_study',
                'english',
                'english_rating',
                'another_lang',
                'another_level',
                'shift_work',
                'consent',
                'experience',
                'sent_to',
            ];
        }

        return [];
    }
}