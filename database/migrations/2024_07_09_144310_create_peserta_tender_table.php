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
        Schema::create('peserta_tender', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('perusahaan_id')->index()->nullable();
            $table->foreignUlid('paket_tender_id')->index()->nullable();
            $table->double('harga_penawaran')->nullable();
            $table->double('harga_terkoreksi')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta_tender');
    }
};
