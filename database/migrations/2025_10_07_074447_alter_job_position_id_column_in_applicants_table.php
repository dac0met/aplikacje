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
            //Zmieniamy kolumnę `pos` na nullable i ustawiamy domyślną wartość NULL
            $table->bigInteger('job_position_id')
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
            // Przywracamy poprzedni stan – zakładam, że pole było NOT NULL
            // i nie miało wartości domyślnej. Dostosuj w razie potrzeby.
            $table->integer('pos')
                  ->nullable(false)
                //   ->default(null)   // usuń tę linię, jeśli nie chcesz żadnej wartości domyślnej
                  ->change();
        });
    }
};
