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
        Schema::table('peserta_tender', function (Blueprint $table) {
            $table->string('persentase')->after('harga_terkoreksi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peserta_tender', function (Blueprint $table) {
            $table->dropColumn('persentase');
        });
    }
};
