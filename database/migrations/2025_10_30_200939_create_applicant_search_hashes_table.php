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
        Schema::create('applicant_search_hashes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained()->cascadeOnDelete();
            // MariaDB 10.x: enum jest OK, ale jeśli wolisz, użyj string(16) i waliduj w aplikacji
            $table->enum('field', ['firstname','lastname','name','email','phone']);
            $table->char('hash', 64); // sha256 hex
            $table->timestamps();

            $table->index(['field', 'hash']);      // dla zapytań po polu i hashu
            $table->index('applicant_id');         // dla szybkiego czyszczenia i joinów
            // (opcjonalnie) unikaj duplikatów:
            $table->unique(['applicant_id','field','hash']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_search_hashes');
    }
};
