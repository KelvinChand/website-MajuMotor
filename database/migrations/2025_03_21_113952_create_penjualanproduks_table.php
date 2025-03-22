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
        Schema::create('penjualanproduks', function (Blueprint $table) {
            $table->uuid('idPenjualanProduk')
            ->primary();
            $table->double('jumlah');
            $table->integer('kuantitas');
            $table->foreignUuid('idPenjualan')
                ->references('idPenjualan')
                ->on('penjualans')
                ->onDelete('cascade');
            $table->foreignUuid('idProduk')
                ->references('idProduk')
                ->on('produks')
                ->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualanproduks');
    }
};
