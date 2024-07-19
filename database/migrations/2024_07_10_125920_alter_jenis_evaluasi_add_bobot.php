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
        Schema::table('data_jenis_evaluasi', function (Blueprint $table) {
            $table->float('bobot1')->after('nama_jenis')->nullable();
            $table->float('bobot2')->after('bobot1')->nullable();
            $table->float('bobot3')->after('bobot2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_jenis_evaluasi', function (Blueprint $table) {
            $table->dropColumn(['bobot1', 'bobot2', 'bobot3']);
        });
    }
};
