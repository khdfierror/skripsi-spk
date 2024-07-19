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
        Schema::create('data_perusahaan', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('npwp', 20)->nullable()->index();
            $table->string('nama_perusahaan')->nullable();
            $table->string('nama_pimpinan')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('telepon_perusahaan')->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('data_satker', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('kode_satker')->nullable();
            $table->string('nama_satker')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('data_ppk', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('satker_id')->nullable();
            $table->string('nip', 25)->nullable()->index();
            $table->string('nama_ppk')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('data_paket_tender', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('satker_id')->nullable();
            $table->foreignUlid('ppk_id')->nullable();
            $table->smallInteger('tahun')->nullable()->index();
            $table->string('kode_paket')->nullable()->index();
            $table->string('nama_paket')->nullable();
            $table->string('nama_kegiatan')->nullable();
            $table->string('nama_sub_kegiatan')->nullable();
            $table->double('pagu')->nullable()->default(0);
            $table->double('hps')->nullable()->default(0);
            $table->string('kualifikasi')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('data_jenis_evaluasi', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('no')->nullable();
            $table->string('nama_jenis')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('data_evaluasi', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('jenis_evaluasi_id')->nullable();
            $table->text('uraian')->nullable();
            $table->string('no')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_perusahaan');
        Schema::dropIfExists('data_satker');
        Schema::dropIfExists('data_ppk');
        Schema::dropIfExists('data_paket_tender');
        Schema::dropIfExists('data_jenis_evaluasi');
        Schema::dropIfExists('data_evaluasi');
    }
};
