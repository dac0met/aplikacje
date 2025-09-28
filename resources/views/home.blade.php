
{{-- resources/views/home.blade.php --}}
{{-- Layout Jetstream (z Tailwind) --}}
<x-app-layout>

    {{-- Opcjonalny nagłówek w sekcji "header" --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Application Form') }}
        </h2>
    </x-slot>

    {{-- Główna zawartość strony --}}
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Montujemy nasz komponent Livewire --}}
            @livewire('applicant-form-component')
        </div>
    </div>
</x-app-layout>

{{-- Dlaczego używamy <x-app-layout> ?
To domyślny layout Jetstream, który już zawiera nagłówek, stopkę i klasy Tailwind. Nie musimy tworzyć własnego szkieletu HTML. --}}
