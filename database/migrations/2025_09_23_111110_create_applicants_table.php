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
            $table->char('name', 30);
            $table->char('surname', 30);
            $table->smallInteger('yob')->nullable();	//Year Of Birth
            $table->char('city', 30)->nullable();
            $table->bigInteger('phone')->nullable();
            $table->char('email', 50)->nullable();
            $table->string('consent', 10)->nullable();	// zgoda na pracę zmianową
            $table->char('job_position', 90)->nullable();
            $table->char('education', 30)->nullable();
            $table->text('university')->nullable();
            $table->text('field_of_study')->nullable();
            $table->char('english', 15)->nullable();
            $table->char('another_lang', 30)->nullable();
            $table->char('another_level', 30)->nullable();
            $table->text('experience')->nullable();
            $table->char('shift_work', 3)->default('');
            $table->integer('salary')->nullable();			//oczekiwania finansowe
            $table->string('cv_pl', 150)->nullable();
            $table->string('cv_gb', 150)->nullable();
            $table->char('status', 20)->nullable();
            $table->char('english_rating', 15)->nullable();
            $table->char('info', 200)->nullable();
            $table->char('sent_to', 50)->nullable();
            $table->char('interview', 255)->nullable();
            $table->char('feedback', 255)->nullable();
            $table->char('gender', 9)->nullable();		// płeć
            $table->char('gross', 6)->nullable();		// brutto/netto
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
