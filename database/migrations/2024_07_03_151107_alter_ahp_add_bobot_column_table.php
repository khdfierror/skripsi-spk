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
        Schema::table('ahp', function (Blueprint $table) {
            $table->string('bobot')->default('bobot 1')->index()->after('nilai')->nullable();
            $table->string('bobot_prioritas')->after('bobot')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ahp', function (Blueprint $table) {
            $table->dropColumn('bobot');
            $table->dropColumn('bobot_prioritas');
        });
    }
};
