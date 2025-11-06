<?php

namespace App\Filament\Admin\Resources\JobPositions\Pages;

use App\Filament\Admin\Resources\JobPositions\JobPositionResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

class CreateJobPosition extends CreateRecord
{
    protected static string $resource = JobPositionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        [$contents, $filename] = $this->buildAnnouncement($data);
        $data['contents'] = $contents;
        $data['filename'] = $filename . '.pdf';
        return $data;
    }

    private function buildAnnouncement(array $data): array
    {
        $lang = $data['lang'] ?? 'en';

        $phraseMap = [
            'en' => 'We are looking for candidates on the position of',
            'pl' => 'Poszukujemy kandydatów do pracy na stanowisku',
        ];
        $lookingFor = $data['looking_for_candidates'] ?? $phraseMap[$lang] ?? $phraseMap['en'];
        if (in_array($data['looking_for_candidates'] ?? '', ['en','pl'], true)) {
            $lookingFor = $phraseMap[$lang] ?? $phraseMap['en'];
        }

        $respItems = self::splitLines($data['resp_items_text'] ?? '');
        $reqItems = self::splitLines($data['req_items_text'] ?? '');
        $offerItems = self::splitLines($data['offer_items_text'] ?? '');

        $fileBase = Str::of($data['name'] ?? 'job_offer')->snake('_');

        $clauses = view($lang === 'pl' ? 'clauses.clauses_cv_pl' : 'clauses.clauses_cv_gb')->render();

        if (! View::exists('announcement-template')) {
            throw new \RuntimeException('Blade view "announcement-template" is missing or view paths misconfigured.');
}
        $html = view('announcement-template', [
            'lookingForCandidates' => $lookingFor,
            'nameOfThePosition' => $data['name'] ?? '',
            'location' => $data['location'] ?? ($lang === 'pl' ? 'Miejsce pracy: Bydgoszcz' : 'Location: Bydgoszcz'),
            'jobDescription' => $data['job_description'] ?? ($lang === 'pl' ? 'Opis stanowiska' : ''),
            'keyResponsibilities' => $data['key_responsibilities'] ?? ($lang === 'pl' ? 'Zakres obowiązków' : 'Key responsibilities'),
            'ourRequirements' => $data['our_requirements'] ?? ($lang === 'pl' ? 'Wymagania' : 'Our requirements'),
            'weOffer' => $data['we_offer'] ?? ($lang === 'pl' ? 'Oferujemy' : 'We offer'),
            'option1' => $data['option1'] ?? '',
            'option2Title' => $data['option2_title'] ?? '',
            'option2' => $data['option2'] ?? '',
            'option3' => $data['option3'] ?? '',
            'respItems' => $respItems,
            'reqItems' => $reqItems,
            'offerItems' => $offerItems,
            'file_name' => (string) $fileBase,
            'clauses' => $clauses,
        ])->render();

        return [$html, (string) $fileBase];
    }

    private static function splitLines(string $text): array
    {
        return collect(preg_split("/(\r?\n)+/", trim($text)))
            ->map(fn($l) => trim((string)$l))
            ->filter()
            ->values()
            ->all();
    }
}
