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
        Schema::create('perbandingan_alternatif_administrasi', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('jenis_evaluasi_id')->index()->nullable();
            $table->foreignUlid('kiri_perusahaan_id')->constrained('data_perusahaan')->cascadeOnDelete();
            $table->foreignUlid('atas_perusahaan_id')->constrained('data_perusahaan')->cascadeOnDelete();
            $table->float('nilai')->default(0);
            $table->float('bobot')->default(0);
            $table->timestamps();
        });

        Schema::create('perbandingan_alternatif_kualifikasi', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('jenis_evaluasi_id')->index()->nullable();
            $table->foreignUlid('kiri_perusahaan_id')->constrained('data_perusahaan')->cascadeOnDelete();
            $table->foreignUlid('atas_perusahaan_id')->constrained('data_perusahaan')->cascadeOnDelete();
            $table->float('nilai')->default(0);
            $table->float('bobot')->default(0);
            $table->timestamps();
        });

        Schema::create('perbandingan_alternatif_teknis', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('jenis_evaluasi_id')->index()->nullable();
            $table->foreignUlid('kiri_perusahaan_id')->constrained('data_perusahaan')->cascadeOnDelete();
            $table->foreignUlid('atas_perusahaan_id')->constrained('data_perusahaan')->cascadeOnDelete();
            $table->float('nilai')->default(0);
            $table->float('bobot')->default(0);
            $table->timestamps();
        });

        Schema::create('perbandingan_alternatif_harga', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('jenis_evaluasi_id')->index()->nullable();
            $table->foreignUlid('kiri_perusahaan_id')->constrained('data_perusahaan')->cascadeOnDelete();
            $table->foreignUlid('atas_perusahaan_id')->constrained('data_perusahaan')->cascadeOnDelete();
            $table->float('nilai')->default(0);
            $table->float('bobot')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perbandingan_alternatif_administrasi');
        Schema::dropIfExists('perbandingan_alternatif_kualifikasi');
        Schema::dropIfExists('perbandingan_alternatif_teknis');
        Schema::dropIfExists('perbandingan_alternatif_harga');
    }
};
