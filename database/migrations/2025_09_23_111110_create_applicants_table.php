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
            $table->integer('submission_id')->nullable();
            $table->foreignId('job_position_id')->constrained()->cascadeOnDelete();
            $table->dateTime('submitted_date')->nullable();
            $table->char('user_ip', 15)->nullable();
            $table->string('name', 30);
            $table->string('surname', 30);
            $table->smallInteger('yob')->nullable();	//Year Of Birth
            $table->string('city', 30)->nullable();
            $table->bigInteger('phone')->nullable();
            $table->string('email', 50)->nullable();
            $table->string('consent', 10)->nullable();	// zgoda na pracę zmianową
            $table->string('job_position', 90)->nullable();
            $table->string('education', 30)->nullable();
            $table->string('university')->nullable();
            $table->string('field_of_study')->nullable();
            $table->char('english', 15)->nullable();
            $table->string('another_lang', 30)->nullable();
            $table->char('another_level', 30)->nullable();
            $table->string('experience')->nullable();
            $table->char('shift_work', 3)->default('');
            $table->integer('salary')->nullable();			//oczekiwania finansowe
            $table->string('cv_pl', 150)->nullable();
            $table->string('cv_gb', 150)->nullable();
            $table->string('status', 20)->nullable();
            $table->string('english_rating', 15)->nullable();
            $table->string('info', 200)->nullable();
            $table->string('sent_to', 50)->nullable();
            $table->string('interview', 255)->nullable();
            $table->string('feedback', 255)->nullable();
            $table->string('gender', 9)->nullable();		// płeć
            $table->string('gross', 6)->nullable();		// brutto/netto
            $table->string('consent_source', 40)->nullable();
            $table->string('notes', 255)->nullable();
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
