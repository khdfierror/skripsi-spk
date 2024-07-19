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
        Schema::create('penilaian_administrasi', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('peserta_tender_id')->nullable()->index();
            $table->foreignUlid('perusahaan_id')->nullable()->index();
            $table->foreignUlid('paket_tender_id')->nullable()->index();
            $table->foreignUlid('evaluasi_id')->nullable()->index();

            $table->text('keterangan')->nullable();
            $table->float('bobot')->nullable();
            $table->float('jumlah')->nullable();

            $table->integer('nilai_1')->nullable();
            $table->integer('nilai_2')->nullable();
            $table->integer('nilai_3')->nullable();
            $table->integer('nilai_4')->nullable();
            $table->integer('nilai_5')->nullable();
            $table->timestamps();
        });

        Schema::create('penilaian_kualifikasi', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('perusahaan_id')->nullable()->index();
            $table->foreignUlid('paket_tender_id')->nullable()->index();
            $table->foreignUlid('evaluasi_id')->nullable()->index();

            $table->float('bobot')->nullable();
            $table->float('jumlah')->nullable();
            $table->text('keterangan')->nullable();

            $table->integer('nilai_1')->nullable();
            $table->integer('nilai_2')->nullable();
            $table->integer('nilai_3')->nullable();
            $table->integer('nilai_4')->nullable();
            $table->integer('nilai_5')->nullable();
            $table->timestamps();
        });

        Schema::create('penilaian_teknis', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('perusahaan_id')->nullable()->index();
            $table->foreignUlid('paket_tender_id')->nullable()->index();
            $table->foreignUlid('evaluasi_id')->nullable()->index();

            $table->float('bobot')->nullable();
            $table->float('jumlah')->nullable();
            $table->text('keterangan')->nullable();

            $table->integer('nilai_1')->nullable();
            $table->integer('nilai_2')->nullable();
            $table->integer('nilai_3')->nullable();
            $table->integer('nilai_4')->nullable();
            $table->integer('nilai_5')->nullable();
            $table->timestamps();
        });

        Schema::create('penilaian_harga', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('perusahaan_id')->nullable()->index();
            $table->foreignUlid('paket_tender_id')->nullable()->index();
            $table->foreignUlid('evaluasi_id')->nullable()->index();

            $table->float('bobot')->nullable();
            $table->float('jumlah')->nullable();
            $table->text('keterangan')->nullable();

            $table->integer('nilai_1')->nullable();
            $table->integer('nilai_2')->nullable();
            $table->integer('nilai_3')->nullable();
            $table->integer('nilai_4')->nullable();
            $table->integer('nilai_5')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_administrasi');
        Schema::dropIfExists('penilaian_kualifikasi');
        Schema::dropIfExists('penilaian_teknis');
        Schema::dropIfExists('penilaian_harga');
    }
};
