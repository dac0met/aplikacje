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
            // Dodajemy pola searchable dla wyszukiwania zaszyfrowanych danych
            $table->string('firstname_searchable', 100)->nullable()->index();
            $table->string('lastname_searchable', 100)->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropColumn(['firstname_searchable', 'lastname_searchable']);
        });
    }
};
