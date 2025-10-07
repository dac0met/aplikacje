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
            $table->bigInteger('consent_source_id')
                  ->nullable()
                  ->default(null)
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            /// Przywracamy poprzedni stan – zakładam, że pole było NOT NULL
            // i nie miało wartości domyślnej. Dostosuj w razie potrzeby.
            $table->integer('consent_source_id')
                  ->nullable(false)
                //   ->default(null)   // usuń tę linię, jeśli nie chcesz żadnej wartości domyślnej
                  ->change();
        });
    }
};
