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
            // Usuwamy stare pola searchable
            $table->dropColumn(['firstname_searchable', 'lastname_searchable']);
            
            // Dodajemy nowe pola z hashami wyszukiwania
            $table->text('firstname_search_hashes')->nullable();
            $table->text('lastname_search_hashes')->nullable();
            
            // Dodajemy indeksy dla lepszej wydajności wyszukiwania
            $table->index('firstname_search_hashes');
            $table->index('lastname_search_hashes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            // Usuwamy nowe pola z hashami
            $table->dropColumn(['firstname_search_hashes', 'lastname_search_hashes']);
            
            // Przywracamy stare pola searchable
            $table->string('firstname_searchable', 100)->nullable()->index();
            $table->string('lastname_searchable', 100)->nullable()->index();
        });
    }
};
