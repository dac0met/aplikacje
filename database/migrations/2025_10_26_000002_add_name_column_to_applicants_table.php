<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            // Dodajemy rzeczywiste pole name do bazy danych
            $table->text('name')->nullable();
            
            // Dodajemy indeks dla lepszej wydajności wyszukiwania
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            // Usuwamy pole name
            $table->dropColumn('name');
        });
    }
};
