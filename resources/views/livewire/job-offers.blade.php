<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Job offers</h1>

    @php $hasItems = isset($positions) && $positions->count() > 0; @endphp

    @if(!$hasItems)
        <p class="mt-6 text-gray-600 dark:text-gray-300">No job offers available.</p>
    @else
        <div class="mt-6 space-y-4">
            @foreach ($positions as $position)
                <details class="group rounded-lg border border-gray-200 dark:border-white/10 bg-white/50 dark:bg-gray-800/40 open:bg-white dark:open:bg-gray-800 shadow-sm">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-4 py-3 select-none">
                        <span class="text-base font-medium text-gray-900 dark:text-white">{{ $position->name }}</span>
                        <svg class="size-5 text-gray-500 transition group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </summary>
                    <div class="px-4 pb-4">
                        <div class="prose max-w-none prose-ul:list-disc prose-li:marker:text-gray-500 dark:prose-invert">
                            {!! $position->contents !!}
                        </div>
                    </div>
                </details>
            @endforeach
        </div>
    @endif
</div>
