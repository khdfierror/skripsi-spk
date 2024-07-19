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
        Schema::create('paket_bobot', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('paket_tender_id')->nullable()->index();
            $table->foreignUlid('evaluasi_id')->nullable()->index();
            $table->string('nilai_bobot')->nullable();
            $table->double('jumlah_bobot')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_bobot');
    }
};
