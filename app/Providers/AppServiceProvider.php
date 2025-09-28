<?php

namespace App\Providers;

// use Livewire\Livewire;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
// use App\Livewire\ApplicantFormComponent;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        // Livewire::component('applicant-form-component', ApplicantFormComponent::class);
    }
}
