<x-app-layout>

    <div class="min-h-[60vh] flex items-center justify-center px-4">
        <div class="max-w-lg w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow p-8 text-center">
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Thank you!</h1>
            <p class="mt-3 text-base text-gray-700 dark:text-gray-200">Your form has been submitted and confirmed.</p>
            <div class="mx-auto h-14 w-14 flex items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30 mb-4 mt-4">
                <!-- Check Circle Icon -->
                <svg class="h-16 w-16 text-green-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2s10 4.477 10 10z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>
    </div>
    @section('gdpr')
        {{-- nie renderujemy bloków rodo --}}
    @endsection

    @section('footer')
        {{-- nie renderujemy stopki --}}
    @endsection

</x-app-layout>

