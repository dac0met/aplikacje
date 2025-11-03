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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_position_id')->constrained()->cascadeOnDelete()->nullable();
            $table->foreignId('consent_source_id')->constrained()->cascadeOnDelete()->nullable();
            $table->dateTime('submitted_date')->nullable();
            $table->char('user_ip', 15)->nullable();
            $table->boolean('confirmation')->default(false);
            $table->text('firstname');
            $table->text('lastname');
            $table->smallInteger('yob')->nullable();	//Year Of Birth
            $table->string('city', 30)->nullable();
            $table->text('phone')->nullable();
            $table->text('email')->nullable();
            $table->string('position', 191)->nullable();
            $table->string('consent', 10)->nullable();	// zgoda na pracę zmianową
            $table->string('education', 30)->nullable();
            $table->string('university',191)->nullable();
            $table->string('field_of_study',191)->nullable();
            $table->string('english', 2)->nullable();
            $table->string('another_lang', 30)->nullable();
            $table->string('another_level', 2)->nullable();
            $table->string('experience')->nullable();
            $table->boolean('shift_work')->default(0);
            $table->integer('salary')->nullable();			//oczekiwania finansowe
            $table->string('cv_pl', 150)->nullable();
            $table->string('cv_gb', 150)->nullable();
            $table->string('orig_filename_pl', 150)->nullable();
            $table->string('orig_filename_gb', 150)->nullable();
            $table->string('status', 20)->nullable();
            $table->string('english_rating', 15)->nullable();
            $table->string('sent_to', 50)->nullable();
            $table->string('interview', 191)->nullable();
            $table->string('feedback', 191)->nullable();
            $table->string('gender', 6)->nullable();		// płeć
            $table->string('gross', 6)->nullable();		// brutto/netto
            $table->string('notes', 191)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
