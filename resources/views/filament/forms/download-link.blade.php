@if (!empty($url))
    <a href="{{ $url }}"
       class="inline-flex flex-row flex-nowrap items-center gap-1 whitespace-nowrap leading-none text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 underline decoration-2 decoration-primary-600 dark:decoration-primary-400 underline-offset-4 cursor-pointer">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-none inline align-middle" style="display:inline">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
            <polyline points="7 10 12 15 17 10"/>
            <line x1="12" y1="15" x2="12" y2="3"/>
        </svg>
        <span class="flex-none inline align-middle leading-none whitespace-nowrap">{{ $label ?? 'Download' }}</span>
    </a>
@endif
