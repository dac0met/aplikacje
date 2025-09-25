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
        Schema::create('consent_sources', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();    // np. "web", "email", "custom‑123"
            $table->string('label');            // wyświetlana nazwa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consent_sources');
    }
};
