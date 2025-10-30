<div class="flex items-center gap-2">
    {{-- Ikona jasnego trybu --}}
    <button
        x-data
        x-on:click="$store.theme.setTheme('light')"
        class="p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700"
        title="Tryb jasny"
    >
        <x-heroicon-o-sun class="w-5 h-5" />
    </button>

    {{-- Ikona ciemnego trybu --}}
    <button
        x-data
        x-on:click="$store.theme.setTheme('dark')"
        class="p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700"
        title="Tryb ciemny"
    >
        <x-heroicon-o-moon class="w-5 h-5" />
    </button>
</div>
