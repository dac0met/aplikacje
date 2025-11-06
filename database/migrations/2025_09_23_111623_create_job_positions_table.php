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
        Schema::create('job_positions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('published')->default(false);
            $table->string('lang')->default('en');
            $table->string('looking_for_candidates')->nullable();
            $table->string('location')->nullable();
            $table->string('job_description')->nullable();
            $table->string('key_responsibilities')->nullable();
            $table->text('resp_items_text')->nullable();
            $table->string('our_requirements')->nullable();
            $table->text('req_items_text')->nullable();
            $table->string('we_offer')->nullable();
            $table->text('offer_items_text')->nullable();
            $table->string('option1')->nullable();
            $table->string('option2_title')->nullable();
            $table->string('option2')->nullable();
            $table->string('option3')->nullable();
            $table->text('contents')->nullable();
            $table->string('filename')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_positions');
    }
};
