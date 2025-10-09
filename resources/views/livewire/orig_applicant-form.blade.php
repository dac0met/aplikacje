
{{-- resources/views/livewire/applicant-form.blade.php --}}
{{-- Cały formularz opakowany w kartę z Tailwind --}}
<div class="bg-white shadow-md rounded-lg p-6">



    {{-- Formularz – submit wywołuje metodę submit() w komponencie --}}
    <form wire:submit.prevent="submit" class="space-y-6">

        {{-- ===== Dane osobowe ===== --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium text-sm text-gray-700" for="name">
                    First name
                </label>
                <input id="firstname" type="text"
                       wire:model.defer="firstname"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                       autocomplete="given-name" >
                @error('firstname') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700" for="surname">
                    Last name
                </label>
                <input id="lastname" type="text"
                       wire:model.defer="lastname"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                       autocomplete="family-name" >
                @error('lastname') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            
            <div class="flex items-start">
                <label class="block font-medium text-sm text-gray-700 mr-2" for="city">
                    Place of residence ( City )
                </label>
                <input id="city" type="text"
                       wire:model.defer="city"
                       {{-- class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"> --}}
                       class="mt-1 flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('city') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
        </div>

        {{-- ===== Kontakt ===== --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium text-sm text-gray-700" for="email">
                    E‑mail
                </label>
                <input id="email" type="email"
                       wire:model.defer="email"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700" for="phone">
                    Phone number in the Polish zone
                </label>
                <input id="phone" type="text"
                       wire:model.defer="phone"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('phone') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
        </div>


        {{-- ===== Stanowisko ===== --}}
        {{-- <div>
            <label class="block font-medium text-sm text-gray-700" for="job_position_id">
                Position applied for
            </label>
            <select id="job_position_id"
                    wire:model="job_position_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">-</option>
                @foreach($jobPositions as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
            @error('job_position_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div> --}}

        {{-- ==== Nasz własny Checkbox‑list ==== --}}
        <div class="mt-4">
            <label class="block ml-2 text-sm text-gray-900">Stanowiska, które Cię interesują</label>

            @foreach ($jobPositions as $position)
                <div class="flex items-center space-x-2">
                    <input
                        type="checkbox"
                        value="{{ $position->id }}"
                        wire:model="selected_job_positions"
                        id="job-position-{{ $position->id }}"
                        class="border-gray-300 rounded shadow-sm text-primary-600 focus:ring-primary-500"
                    >
                    <label for="job-position-{{ $position->id }}" class="select-none">
                        {{ $position->name }}
                    </label>
                </div>
            @endforeach

            @error('selected_job_positions') <p class="mt-1 text-red-600">{{ $message }}</p> @enderror
        </div>


        {{-- ===== Praca zmianowa (checkbox) ===== --}}
        <div class="flex items-center">
            <input id="shift_work" type="checkbox"
                   wire:model="shift_work"
                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <label for="shift_work" class="ml-2 block text-sm text-gray-900">
                Willingness to work in shifts
            </label>
            @error('shift_work') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        {{-- PL Upload file --}}
        <div class="sm:col-span-2 mt-8">
            <div class="mt-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                       for="cv_pl">Attach resume in Polish</label>

                {{-- Livewire file input – note the `wire:model="cv_pl"` --}}
                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                       id="cv_pl"
                       type="file"
                       wire:model="cv_pl">

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300"
                   id="file_input_help">pdf, docx, doc, odt (max. 500 KB).</p>

                {{-- Validation feedback --}}
                @error('cv_pl')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

                {{-- GB Upload file (Livewire) --}}
        <div class="sm:col-span-2 mt-4">
            <div class="mt-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                       for="cv_gb">Attach resume in English</label>

                {{-- Livewire file input – note the `wire:model="cv_gb"` --}}
                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                       id="cv_gb"
                       type="file"
                       wire:model="cv_gb">

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300"
                   id="file_input_help">pdf, docx, doc, odt (max. 500 KB).</p>

                {{-- Validation feedback --}}
                @error('cv_gb')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

         {{-- Komunikat sukcesu po zapisaniu (flash) --}}
        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('message') }}
            </div>
        @endif

        {{-- ===== Przycisk wysyłki ===== --}}
        <div class="flex justify-end pt-4 border-t border-gray-200">
            <button type="submit"
                    {{-- class="px-6 py-2 bg-green-600
                     text-white rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"> --}}
                    class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700
                     focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150 z-60"
                    wire:loading.attr="disabled" 
                    wire:target="submit" >
                Send
            </button>
        </div>
    </form>

</div>





