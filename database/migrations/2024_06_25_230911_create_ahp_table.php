<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAhpTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ahp', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('kiri_jenis_evaluasi_id')->constrained('data_jenis_evaluasi')->cascadeOnDelete();
            $table->foreignUlid('atas_jenis_evaluasi_id')->constrained('data_jenis_evaluasi')->cascadeOnDelete();
            $table->float('nilai')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ahp');
    }
}
