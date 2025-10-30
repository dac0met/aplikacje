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
            // Dodajemy pole name_search_hashes dla globalnego wyszukiwania
            $table->text('name_search_hashes')->nullable();
            
            // Dodajemy indeks dla lepszej wydajności wyszukiwania
            $table->index('name_search_hashes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            // Usuwamy pole name_search_hashes
            $table->dropColumn('name_search_hashes');
        });
    }
};
