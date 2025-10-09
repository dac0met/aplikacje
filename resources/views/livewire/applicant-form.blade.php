<form wire:submit.prevent="submit">
    {{-- <div class="space-y-12"> --}}
    <div>
        <div class="pb-12 border-b border-white/10">
            <h2 class="font-semibold text-white text-base/7">Personal Information</h2>
            <p class="mt-1 text-gray-400 text-sm/6">Use a permanent address where you can receive mail.</p>
            <div class="grid grid-cols-1 mt-10 gap-x-6 gap-y-8 sm:grid-cols-6">
                {{-- First name --}}
                <div class="sm:col-span-3">
                    <label for="firstname" class="block font-medium text-white text-sm/6">First Name</label>
                    <div class="mt-2">
                        <input id="firstname" type="text" 
                            wire:model.defer="firstname" 
                            autocomplete="given-name"
                            class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                        @error('firstname') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Last name --}}
                <div class="sm:col-span-3">
                    <label for="lastname" class="block font-medium text-white text-sm/6">Last Name</label>
                    <div class="mt-2">
                        <input id="lastname" type="text" 
                            wire:model.defer="lastname" 
                            autocomplete="family-name"
                            class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                        @error('lastname') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- ***************** trzy krótkie pola w linii *************************** --}}
                {{-- city --}}
                <div class="sm:col-span-2 sm:col-start-1">
                    <label for="city" class="block font-medium text-white text-sm/6">Place of residence ( City )</label>
                    <div class="mt-2">
                        <input id="city" type="text" 
                            wire:model.defer="city" 
                            autocomplete="city"
                            class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                        @error('city') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- phone --}}
                <div class="sm:col-span-2">
                    <label for="phone" class="block font-medium text-white text-sm/6">Phone number in the Polish
                        zone</label>
                    <div class="mt-2">
                        <input id="phone" type="text" 
                            wire:model.defer="phone" 
                            autocomplete="phone"
                            class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                        @error('phone') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- email --}}
                <div class="sm:col-span-2">
                    <label for="email" class="block font-medium text-white text-sm/6">Email address</label>
                    <div class="mt-2">
                        <input id="email" type="email" 
                            wire:model.defer="email" 
                            autocomplete="email"
                            class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                        @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>  {{-- linia na dole bloku --}}


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


        {{-- SHIFT WORK --}}
        <div class="flex items-center mt-8">
            <div class="flex">
                <label for="shift_work" class="block font-medium text-white text-sm/6 mr-6">Willingness to work in shifts:</label>
                <div class="flex items-center ">
                    <input id="shift_work" type="radio" value="" name="shift_work" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="shift_work" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Yes</label>
                </div>
                <div class="flex items-center">
                    <input id="shift_work" type="radio" value="" name="shift_work" class="ms-4 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="shift_work" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">No</label>
                </div>
            </div>
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
    
    {{-- BUTTON Send--}}
    <div class="flex items-center justify-end mt-6 gap-x-6">

        <button type="submit"
            class="px-3 py-2 text-sm font-semibold text-white bg-indigo-500 rounded-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500"
            wire:loading.attr="disabled" 
            wire:target="submit">
            Send
        </button>
    </div>
</form>


