<?php

namespace App\Filament\Admin\Resources\JobPositions\Pages;

use App\Filament\Admin\Resources\JobPositions\JobPositionResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EditJobPosition extends EditRecord
{
    protected static string $resource = JobPositionResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        [$contents, $filename] = $this->buildAnnouncement($data);
        $data['contents'] = $contents;
        $data['filename'] = $filename . '.pdf';
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generatePdf')
                ->label('Generate PDF')
                ->action(function () {
                    $record = $this->getRecord();
                    if (!class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
                        // dompdf not installed
                        return;
                    }
                    // Generate strictly from persisted DB values
                    $record = $this->getRecord()->refresh();
                    [$html, $fileBase] = $this->buildAnnouncement(array_merge($record->toArray(), [ 'forPdf' => true ]), true);

                    // Wrap HTML with UTF-8 meta and apply global typography/layout
                    $titleSize = (int) config('job_pdf.title_font_size', 18);
                    $bodySize  = (int) config('job_pdf.body_font_size', 12);
                    $lineHeight = (float) config('job_pdf.line_height', 1.4);
                    $listIndent = (int) config('job_pdf.list_indent', 16);
                    $mTop    = (int) config('job_pdf.margin_top', 24);
                    $mRight  = (int) config('job_pdf.margin_right', 24);
                    $mBottom = (int) config('job_pdf.margin_bottom', 24);
                    $mLeft   = (int) config('job_pdf.margin_left', 24);

                    $wrappedHtml = <<<HTML
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: {$mTop}px {$mRight}px {$mBottom}px {$mLeft}px; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: {$bodySize}px; line-height: {$lineHeight}; }
        p strong { font-size: {$titleSize}px; }
        ul { margin-left: {$listIndent}px; padding-left: {$listIndent}px; }
        li { margin-bottom: 4px; }
    </style>
</head>
<body>
{$html}
</body>
</html>
HTML;

                    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($wrappedHtml);
                    $finalName = (string) ($record->filename ?: (string) $fileBase ?: Str::of($record->name)->snake('_'));
                    if (!Str::of($finalName)->endsWith('.pdf')) { $finalName .= '.pdf'; }
                    $relativePath = 'job_descriptions/' . $finalName;
                    Storage::disk('public')->put($relativePath, $pdf->output());
                }),
            Action::make('viewPdf')
                ->label('View PDF')
                ->url(fn () => route('job-positions.pdf', $this->getRecord()))
                // ->url(function () {
                //     $record = $this->getRecord()->refresh();
                //     $fileBase = Str::of($record->name)->snake('_');
                //     $finalName = (string) ($record->filename ?: (string) $fileBase);
                //     if (!Str::of($finalName)->endsWith('.pdf')) { $finalName .= '.pdf'; }
                //     $relativePath = 'job_descriptions/' . $finalName;
                //     return Storage::disk('public')->url($relativePath);
                // })
                ->openUrlInNewTab()
                ->visible(function () {
                    $record = $this->getRecord()->refresh();
                    $fileBase = Str::of($record->name)->snake('_');
                    $finalName = (string) ($record->filename ?: (string) $fileBase);
                    if (!Str::of($finalName)->endsWith('.pdf')) { $finalName .= '.pdf'; }
                    $relativePath = 'job_descriptions/' . $finalName;
                    return Storage::disk('public')->exists($relativePath);
                }),
            DeleteAction::make(),
        ];
    }

    private function buildAnnouncement(array $data, bool $forPdf = false): array
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
            'forPdf' => $forPdf,
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
