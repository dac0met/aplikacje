<form>
    <div class="space-y-12">

        <div class="pb-12 border-b border-white/10">
            <h2 class="font-semibold text-white text-base/7">Personal Information</h2>
            <p class="mt-1 text-gray-400 text-sm/6">Use a permanent address where you can receive mail.</p>
            <div class="grid grid-cols-1 mt-10 gap-x-6 gap-y-8 sm:grid-cols-6">
                {{-- First name --}}
                <div class="sm:col-span-3">
                    <label for="firstname" class="block font-medium text-white text-sm/6">First Name</label>
                    <div class="mt-2">
                        <input id="firstname" type="text" wire:model.defer="firstname" autocomplete="given-name"
                            class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                        @error('firstname') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Last name --}}
                <div class="sm:col-span-3">
                    <label for="lastname" class="block font-medium text-white text-sm/6">Last Name</label>
                    <div class="mt-2">
                        <input id="lastname" type="text" wire:model.defer="lastname" autocomplete="family-name"
                            class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                        @error('lastname') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- ***************** trzy krótkie pola w linii *************************** --}}
                {{-- city --}}
                <div class="sm:col-span-2 sm:col-start-1">
                    <label for="city" class="block font-medium text-white text-sm/6">Place of residence ( City )</label>
                    <div class="mt-2">
                        <input id="city" type="text" wire:model.defer="city" autocomplete="city"
                            class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                        @error('city') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- phone --}}
                <div class="sm:col-span-2">
                    <label for="phone" class="block font-medium text-white text-sm/6">Phone number in the Polish
                        zone</label>
                    <div class="mt-2">
                        <input id="phone" type="text" wire:model.defer="phone" autocomplete="phone"
                            class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                        @error('phone') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- email --}}
                <div class="sm:col-span-2">
                    <label for="email" class="block font-medium text-white text-sm/6">Email address</label>
                    <div class="mt-2">
                        <input id="email" type="email" wire:model.defer="email" autocomplete="email"
                            class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                        @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>  {{-- linia na dole bloku --}}


        {{-- CHECKBOXY --}}
        <div class="mt-10 space-y-10">
            <fieldset>
                <legend class="font-semibold text-white text-sm/6">Position applied for:</legend>
                <div class="mt-6 space-y-6">
                    {{-- comments --}}
                    <div class="flex gap-3">
                        <div class="flex items-center h-6 shrink-0">
                            <div class="grid grid-cols-1 group size-4">
                                <input id="comments" type="checkbox" name="comments" checked
                                    aria-describedby="comments-description"
                                    class="col-start-1 row-start-1 border rounded appearance-none border-white/10 bg-white/5 checked:border-indigo-500 checked:bg-indigo-500 indeterminate:border-indigo-500 indeterminate:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 disabled:border-white/5 disabled:bg-white/10 disabled:checked:bg-white/10 forced-colors:appearance-auto" />
                                <svg viewBox="0 0 14 14" fill="none"
                                    class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-[:disabled]:stroke-white/25">
                                    <path d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="opacity-0 group-has-[:checked]:opacity-100" />
                                    <path d="M3 7H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="opacity-0 group-has-[:indeterminate]:opacity-100" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-sm/6">
                            <label for="comments" class="font-medium text-white">Comments</label>

                        </div>
                    </div>
                    {{-- candidates --}}
                    <div class="flex gap-3">
                        <div class="flex items-center h-6 shrink-0">
                            <div class="grid grid-cols-1 group size-4">
                                <input id="candidates" type="checkbox" name="candidates"
                                    aria-describedby="candidates-description"
                                    class="col-start-1 row-start-1 border rounded appearance-none border-white/10 bg-white/5 checked:border-indigo-500 checked:bg-indigo-500 indeterminate:border-indigo-500 indeterminate:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 disabled:border-white/5 disabled:bg-white/10 disabled:checked:bg-white/10 forced-colors:appearance-auto" />
                                <svg viewBox="0 0 14 14" fill="none"
                                    class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-[:disabled]:stroke-white/25">
                                    <path d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="opacity-0 group-has-[:checked]:opacity-100" />
                                    <path d="M3 7H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="opacity-0 group-has-[:indeterminate]:opacity-100" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-sm/6">
                            <label for="candidates" class="font-medium text-white">Candidates</label>

                        </div>
                    </div>
                    {{-- offers --}}
                    <div class="flex gap-3">
                        <div class="flex items-center h-6 shrink-0">
                            <div class="grid grid-cols-1 group size-4">
                                <input id="offers" type="checkbox" name="offers"
                                    aria-describedby="offers-description"
                                    class="col-start-1 row-start-1 border rounded appearance-none border-white/10 bg-white/5 checked:border-indigo-500 checked:bg-indigo-500 indeterminate:border-indigo-500 indeterminate:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 disabled:border-white/5 disabled:bg-white/10 disabled:checked:bg-white/10 forced-colors:appearance-auto" />
                                <svg viewBox="0 0 14 14" fill="none"
                                    class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-[:disabled]:stroke-white/25">
                                    <path d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="opacity-0 group-has-[:checked]:opacity-100" />
                                    <path d="M3 7H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="opacity-0 group-has-[:indeterminate]:opacity-100" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-sm/6">
                            <label for="offers" class="font-medium text-white">Offers</label>

                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
            {{-- koniec checkboxów --}}

        <div class="pb-12 border-b border-white/10">
            {{--***************** trzy krótkie pola w linii ***************************--}}
            <div class="grid grid-cols-1 mt-10 gap-x-6 gap-y-8 sm:grid-cols-6">
                {{-- Education --}}
                <div class="sm:col-span-2">
                <label for="education" class="block font-medium text-white text-sm/6">Education>
                    <div class="grid grid-cols-1 mt-2">
                        <select id="education" autocomplete="education" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white/5 py-1.5 pl-3 pr-8 text-base text-white outline outline-1 -outline-offset-1 outline-white/10 *:bg-gray-800 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6">
                        <option>United States</option>
                        <option>Canada</option>
                        <option>Mexico</option>
                        </select>
                    </div>
                </div>

                {{-- University --}}
                <div class="sm:col-span-2">
                    <label for="university" class="block font-medium text-white text-sm/6">University</label>
                    <div class="mt-2">
                        <input id="university" type="text" name="university" autocomplete="address-level1"
                            class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                    </div>
                </div>

                {{-- Field of Study --}}
                <div class="sm:col-span-2">
                    <label for="field_of_study" class="block font-medium text-white text-sm/6">Field of Study</label>
                    <div class="mt-2">
                        <input id="field_of_study" type="text" name="field_of_study" autocomplete="postal-code"
                            class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
                    </div>
                </div>
            </div>
        </div>  {{-- linia na dole bloku --}}

        <div class="sm:col-span-2">
                <label for="english" class="block font-medium text-white text-sm/6">Education>
                <div class="grid grid-cols-1 mt-2">
                    <select id="english" autocomplete="english" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white/5 py-1.5 pl-3 pr-8 text-base text-white outline outline-1 -outline-offset-1 outline-white/10 *:bg-gray-800 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6">
                    <option>United States</option>
                    <option>Canada</option>
                    <option>Mexico</option>
                    </select>
                </div>
        </div>


    </div>

    {{-- BUTTONS --}}
    <div class="flex items-center justify-end mt-6 gap-x-6">

        <button type="submit"
            class="px-3 py-2 text-sm font-semibold text-white bg-indigo-500 rounded-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500"
            wire:loading.attr="disabled" wire:target="submit" >Sand</button>
    </div>
</form>
