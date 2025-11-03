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
        Schema::table('user_table_preferences', function (Blueprint $table) {
            $table->unique(['user_id','table_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_table_preferences', function (Blueprint $table) {
            $table->dropUnique('user_table_preferences_user_id_table_key_unique');
        });
    }
};
