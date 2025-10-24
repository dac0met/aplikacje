
<div>

    <form wire:submit.prevent="submit"
        wire:key="form_{{ $this->fileInputKey }}" >     {{-- niezbędne do resetowania formularza --}}
        @csrf
        {{-- <div class="space-y-12"> --}}
        <div class="max-w-3xl mx-auto p-6 sm:p-8 bg-white/80 dark:bg-gray-800 shadow rounded-lg space-y-6">
            <div class="pb-12 border-b border-gray-500 dark:border-white/10">
                <h2 class="text-2xl/7 text-center font-semibold text-gray-900 dark:text-white ">Application Form</h2>
                <p class="mt-1 text-gray-600 dark:text-gray-400 text-sm/6">Use a permanent address where you can receive mail.</p>
                <div class="grid grid-cols-1 mt-10 gap-x-6 gap-y-8 sm:grid-cols-6">
                    {{-- First name --}}
                    <div class="sm:col-span-3">
                        <label for="firstname" class="block font-medium text-gray-900 dark:text-white text-sm/6">First Name<span class="text-red-600 dark:text-red-500 text-base"> *</span></label>
                        <div class="mt-2">
                            <input id="firstname" type="text"
                                wire:model.defer="firstname"
                                {{-- autocomplete="firstname" --}}
                                class="block w-full rounded-md bg-white dark:bg-gray-700 px-3 py-1.5 text-base text-gray-900 dark:text-white outline outline-1 -outline-offset-1 outline-gray-300 dark:outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                            @error('firstname') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Last name --}}
                    <div class="sm:col-span-3">
                        <label for="lastname" class="block font-medium text-gray-900 dark:text-white text-sm/6">Last Name<span class="text-red-600 dark:text-red-500 text-base"> *</span></label>
                        <div class="mt-2">
                            <input id="lastname" type="text"
                                wire:model.defer="lastname"
                                {{-- autocomplete="lastname" --}}
                                class="block w-full rounded-md bg-white dark:bg-gray-700 px-3 py-1.5 text-base text-gray-900 dark:text-white outline outline-1 -outline-offset-1 outline-gray-300 dark:outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                            @error('lastname') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- ***************** trzy krótkie pola w linii *************************** --}}
                    {{-- city --}}
                    <div class="sm:col-span-2 sm:col-start-1">
                        <label for="city" class="block font-medium text-gray-900 dark:text-white text-sm/6">Place of residence ( City )</label>
                        <div class="mt-2">
                            <input id="city" type="text"
                                wire:model.defer="city"
                                {{-- autocomplete="city" --}}
                                class="block w-full rounded-md bg-white dark:bg-gray-700 px-3 py-1.5 text-base text-gray-900 dark:text-white outline outline-1 -outline-offset-1 outline-gray-300 dark:outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                            @error('city') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- phone --}}
                    <div class="sm:col-span-2">
                        <label for="phone" class="block font-medium text-gray-900 dark:text-white text-sm/6">Phone number in the Polish zone<span class="text-red-600 dark:text-red-500 text-base"> *</span></label>
                        <div class="mt-2">
                            <input id="phone" type="text"
                                wire:model.defer="phone"
                                {{-- autocomplete="phone" --}}
                                class="block w-full rounded-md bg-white dark:bg-gray-700 px-3 py-1.5 text-base text-gray-900 dark:text-white outline outline-1 -outline-offset-1 outline-gray-300 dark:outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                            @error('phone') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- email --}}
                    <div class="sm:col-span-2">
                        <label for="email" class="block font-medium text-gray-900 dark:text-white text-sm/6">Email address<span class="text-red-600 dark:text-red-500 text-base"> *</span></label>
                        <div class="mt-2">
                            <input id="email" type="email"
                                wire:model.defer="email"
                                autocomplete="email"
                                class="block w-full rounded-md bg-white dark:bg-gray-700 px-3 py-1.5 text-base text-gray-900 dark:text-white outline outline-1 -outline-offset-1 outline-gray-300 dark:outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                            @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>  {{-- linia na dole bloku --}}

            {{-- ==== Nasz własny Checkbox‑list ==== --}}
            <div class="mt-4">
                <label class="block text-base font-medium text-gray-900 dark:text-white">Position applied for:<span class="text-red-600 dark:text-red-500 text-base"> *</span></label>

                @foreach ($jobPositions as $position)
                <div class="flex gap-3 mt-2">
                    <div class="flex items-center h-6 shrink-0">
                        <div class="grid grid-cols-1 group size-4">
                            <input
                                type="checkbox"
                                value="{{ $position->id }}"
                                wire:model="selected_job_positions"
                                id="job-position-{{ $position->id }}"
                                class="col-start-1 row-start-1 border rounded appearance-none  bg-white dark:bg-gray-700 checked:border-indigo-500 checked:bg-indigo-500 indeterminate:border-indigo-500 indeterminate:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500  forced-colors:appearance-auto" />
                        </div>
                    </div>
                            <label for="job-position-{{ $position->id }}" class="block font-medium text-gray-900 dark:text-white select-none text-sm/6">
                                {{ $position->name }}
                            </label>
                </div>
                @endforeach

                @error('selected_job_positions') <p class="mt-1 text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="pb-12 border-b border-white/10">
                {{--***************** trzy krótkie pola w linii ***************************--}}
                <div class="grid grid-cols-1 mt-10 gap-x-6 gap-y-8 sm:grid-cols-6">
                    {{-- Education --}}
                    <div class="sm:col-span-2">
                    <label for="education" class="block font-medium text-gray-900 dark:text-white text-sm/6">Education<span class="text-red-600 dark:text-red-500 text-base"> *</span></label>
                        <div class="grid grid-cols-1 mt-2">
                            <select id="education"
                                placeholder="this field is required"
                                {{-- autocomplete="education" --}}
                                wire:model="education"
                                class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white dark:bg-gray-700 py-1.5 pl-3 pr-8 text-base text-gray-900 dark:text-white outline outline-1 -outline-offset-1 outline-gray-300 dark:outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                                <option> </option>
                                <option>masters degree</option>
                                <option>bachelor degree</option>
                                <option>doctoral degree</option>
                                <option>engineer</option>
                                <option>student</option>
                            </select>
                        </div>
                        @error('education') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    {{-- University --}}
                    <div class="sm:col-span-2">
                        <label for="university" class="block font-medium text-gray-900 dark:text-white text-sm/6">University<span class="text-red-600 dark:text-red-500 text-base"> *</span></label>
                        <div class="mt-2">
                            <input id="university" type="text" name="university"
                                autocomplete="university"
                                wire:model.defer="university"
                                class="block w-full rounded-md bg-white dark:bg-gray-700 px-3 py-1.5 text-base text-gray-900 dark:text-white outline outline-1 -outline-offset-1 outline-gray-300 dark:outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                            @error('university') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Field of Study --}}
                    <div class="sm:col-span-2">
                        <label for="field_of_study" class="block font-medium text-gray-900 dark:text-white text-sm/6">Field of Study<span class="text-red-600 dark:text-red-500 text-base"> *</span></label>
                        <div class="mt-2">
                            <input id="field_of_study" type="text" name="field_of_study"
                                autocomplete="field_of_study"
                                wire:model.defer="field_of_study"
                                class="block w-full rounded-md bg-white dark:bg-gray-700 px-3 py-1.5 text-base text-gray-900 dark:text-white outline outline-1 -outline-offset-1 outline-gray-300 dark:outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                            @error('field_of_study') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- Experience --}}
                <div class="mt-8 sm:col-span-2">
                    <label for="experience" class="block font-medium text-gray-900 dark:text-white text-sm/6">Most important skills, certificates, programming languages, etc.<span class="text-red-600 dark:text-red-500 text-base"> *</span></label>
                    <div class="mt-2">
                        <textarea id="experience" type="text" name="experience"
                            {{-- autocomplete="experience" --}}
                            wire:model.defer="experience"
                            class="block w-full rounded-md bg-white dark:bg-gray-700 px-3 py-1.5 text-base text-gray-900 dark:text-white outline outline-1 -outline-offset-1 outline-gray-300 dark:outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                        </textarea>
                        @error('experience') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>  {{-- linia na dole bloku --}}

            <div class="pb-12 border-b border-white/10">
                {{-- English --}}
                <div class="grid grid-cols-1 mt-8 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-2">
                        <label for="english" class="block font-medium text-gray-900 dark:text-white text-sm/6 ">Level of English<span class="text-red-600 dark:text-red-500 text-base"> *</span></label>
                        <div class="grid grid-cols-1 mt-2">
                            <select id="english"
                                {{-- autocomplete="english" --}}
                                wire:model.defer="english"
                                class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white dark:bg-gray-700 py-1.5 pl-3 pr-8 text-base text-gray-900 dark:text-white outline outline-1 -outline-offset-1 outline-gray-300 dark:outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                                <option> </option>
                                <option>A1</option>
                                <option>A2</option>
                                <option>B1</option>
                                <option>B2</option>
                                <option>C1</option>
                                <option>C2</option>
                            </select>
                            @error('english') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                    <label for="another_lang" class="block font-medium text-gray-900 dark:text-white text-sm/6">Other languages</label>
                        <div class="mt-2">
                            <input id="another_lang" type="text" name="another_lang"
                                autocomplete="another_lang"
                                wire:model.defer="another_lang"
                                class="block w-full rounded-md bg-white dark:bg-gray-700 px-3 py-1.5 text-base text-gray-900 dark:text-white outline outline-1 -outline-offset-1 outline-gray-300 dark:outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="another_level" class="block font-medium text-gray-900 dark:text-white text-sm/6">Level of those languages</label>
                        <div class="grid grid-cols-1 mt-2">
                            <select id="another_level"
                                {{-- autocomplete="another_level" --}}
                                wire:model.defer="another_level"
                                class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white dark:bg-gray-700 py-1.5 pl-3 pr-8 text-base text-gray-900 dark:text-white outline outline-1 -outline-offset-1 outline-gray-300 dark:outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                                <option> </option>
                                <option>A1</option>
                                <option>A2</option>
                                <option>B1</option>
                                <option>B2</option>
                                <option>C1</option>
                                <option>C2</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 mt-8 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="font-medium text-white sm:col-span-2 text-sm/6">
                            <label class="block font-medium text-gray-500 dark:text-gray-400 text-sm/6">A1 - Beginner</label>
                            <label class="block font-medium text-gray-500 dark:text-gray-400 text-sm/6">A2 - Pre-Intermediate</label>
                            <label class="block font-medium text-gray-500 dark:text-gray-400 text-sm/6">B1 - Intermediate</label>
                            <label class="block font-medium text-gray-500 dark:text-gray-400 text-sm/6">B2 - Upper-Intermediate</label>
                            <label class="block font-medium text-gray-500 dark:text-gray-400 text-sm/6">C1 - Advanced</label>
                            <label class="block font-medium text-gray-500 dark:text-gray-400 text-sm/6">C2 - Proficient</label>
                        </div>
                </div>
            </div>
            {{-- koniec linia na dole bloku --}}

            {{-- SHIFT WORK --}}
            <div class="flex items-center mt-8">
                <div class="flex">
                    <label class="block mr-6 font-medium text-gray-900 dark:text-white text-sm/6">
                        Willingness to work in shifts:<span class="text-red-600"> *</span>
                    </label>

                    <!-- TAK -->
                    <div class="flex items-center">
                        <input
                            id="shift_work_yes"
                            type="radio"
                            name="shift_work"
                            value="1"                     {{-- true / tak --}}
                            wire:model="shift_work"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-400 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800
                            focus:ring-2 dark:bg-gray-700 dark:border-gray-500">
                        <label for="shift_work_yes"
                            class="text-sm font-medium text-gray-900 ms-2 dark:text-gray-300">
                            Yes
                        </label>
                    </div>

                    <!-- NIE -->
                    <div class="flex items-center ms-4">
                        <input
                            id="shift_work_no"
                            type="radio"
                            name="shift_work"
                            value="0"                     {{-- false / nie --}}
                            wire:model="shift_work"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-400 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800
                             focus:ring-2 dark:bg-gray-700 dark:border-gray-500">
                        <label for="shift_work_no"
                            class="text-sm font-medium text-gray-900 ms-2 dark:text-gray-300">
                            No
                        </label>
                    </div>
                </div>
                @error('shift_work') <p class="mt-1 text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- salary --}}
            <div class="sm:col-span-2 mt-8">
                <label for="salary" class="block font-medium text-gray-900 dark:text-white text-sm/6">Salary Expectations (gross, zł)
                </label>
                <div class="grid grid-cols-1  gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="mt-2">
                    <input id="salary" type="number"
                        wire:model.defer="salary"
                        class="block w-full rounded-md bg-white dark:bg-gray-700 px-3 py-1.5 text-base text-gray-900 dark:text-white outline outline-1 -outline-offset-1 outline-gray-300 dark:outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                    @error('salary') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
                </div>
            </div>

            {{-- PL Upload file --}}
            <div class="mt-8 sm:col-span-2">
                <div class="mt-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            for="cv_pl">Attach resume in Polish</label>

                    {{-- Livewire file input – note the `wire:model="cv_pl"` --}}
                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            id="cv_pl"
                            type="file"
                            wire:key="cv_pl_{{ $this->fileInputKey }}"
                            wire:model="cv_pl">

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300"
                        id="file_input_help">pdf, docx, doc, odt (max. 640 KB).</p>

                    {{-- Validation feedback --}}
                    @error('cv_pl')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>

                    {{-- GB Upload file (Livewire) --}}
            <div class="mt-4 sm:col-span-2">
                <div class="mt-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            for="cv_gb">Attach resume in English<span class="text-red-600 dark:text-red-500 text-base"> *</span></label>

                    {{-- Livewire file input – note the `wire:model="cv_gb"` --}}
                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            id="cv_gb"
                            type="file"
                            wire:key="cv_gb_{{ $this->fileInputKey }}"
                            wire:model="cv_gb">

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300"
                        id="file_input_help">pdf, docx, doc, odt (max. 640 KB).</p>

                    {{-- Validation feedback --}}
                    @error('cv_gb')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
            </div>


            <!-- Opis zgody -->
            <p class="text-base text-gray-900 dark:text-gray-100 leading-relaxed">
                I hereby give consent for my personal data included in my offer to be processed
                for the purpose of
                <span class="font-semibold text-red-600 dark:text-red-400">CURRENT </span>recruitment – <span class="font-semibold text-red-600 dark:text-red-400">option A</span>
                </br>or
                </br>of
                <span class="font-semibold text-red-600 dark:text-red-400">CURRENT and FUTURE </span>recruitments – <span class="font-semibold text-red-600 dark:text-red-400">option B</span>,
                in accordance with the General Data Protection Regulation (GDPR).<span class="text-red-600 dark:text-red-500 text-base"> *</span>
            </p>

            <!-- Wybór typu zgody -->
            <div class="flex flex-col gap-4 mt-2">

                <!-- Opcja A -->
                <label class="inline-flex items-center cursor-pointer">
                    <input
                        id="consent_no"
                        type="radio"
                        name="consent"
                        value="current"
                        wire:model="consent"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-400 focus:ring-blue-500
                            dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2
                            dark:bg-gray-700 dark:border-gray-500"/>
                    <span class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                        A - CURRENT recruitment
                    </span>
                </label>

                <!-- Opcja B -->
                <label class="inline-flex items-center cursor-pointer">
                    <input
                        id="consent_yes"
                        type="radio"
                        name="consent"
                        value="future"
                        wire:model="consent"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-400 focus:ring-blue-500
                            dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2
                            dark:bg-gray-700 dark:border-gray-500"/>
                    <span class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                        B - CURRENT and FUTURE recruitments
                    </span>
                </label>
                @error('consent') <p class="mt-1 text-red-600">{{ $message }}</p> @enderror

            </div>


             {{-- Honeypot (ukryte pole) --}}
             <div style="display:none;">
                <input type="text" wire:model="website" autocomplete="off">
            </div>

            {{-- Captcha --}}
            <div>
                <label for="captcha" class="block font-medium text-gray-900 dark:text-white text-sm/6">
                    {{ $captchaQuestion }} <span class="text-red-600">*</span>
                </label>
                <div class="mt-2">
                    <input id="captcha" type="text" wire:model.defer="captchaAnswer"
                        class="block w-full rounded-md bg-white dark:bg-gray-700 px-3 py-1.5 text-base text-gray-900 dark:text-white outline outline-1 -outline-offset-1 outline-gray-300 dark:outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                    @error('captchaAnswer') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>
            

            {{-- checkbox RODO nic nie zapisuje w bazie danych, tylko uaktywnia przycisk 'submit' --}}
            <div class="flex items-center ">
                <input
                    id="rodo"
                    type="checkbox"
                    name="rodo"
                    required
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-400 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-500">
                <label class="text-sm font-medium text-gray-900 ms-2 dark:text-gray-300">I have read the GDPR information below<span class="text-red-600 dark:text-red-500 text-base"> *</span></label>
                @error('rodo') <p class="mt-1 text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- BUTTON Send--}}
            <div class="flex items-center justify-end mt-6 gap-x-6">
                <button type="submit"
                    class="px-3 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 rounded-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500"
                    wire:loading.attr="disabled"
                    wire:target="submit">
                    Send
                </button>
            </div>
        </div>

    </form>


    {{-- Modal – wyświetlany po udanym zapisie --}}

    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="p-6 rounded-lg shadow-xl max-w-sm sm:max-w-md lg:max-w-lg xl:max-w-xl w-full mx-4 bg-white dark:bg-gray-800 border-2 border-indigo-500">
                <h2 class="font-semibold text-center text-gray-900 dark:text-white text-base/7">Thank you for completing the form !</h2>
                <p class="mt-1 text-gray-600 dark:text-gray-100 text-sm/6">A message with a confirmation link has been sent to the email address provided. </br>
                    Click on the link to complete the process.</br> The link is valid for 24 hours !</p>

                <div class="mt-4 flex justify-end">
                    <button wire:click="$set('showModal', false)" class="px-3 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 rounded-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endif
                                            {{-- Szerokość okienka modalnego:
                                            Mobilne (max-w-sm): ~384px
                                            Tablety (sm:max-w-md): ~448px
                                            Laptopy (lg:max-w-lg): ~512px
                                            Duże ekrany (xl:max-w-xl): ~576px --}}
</div>
