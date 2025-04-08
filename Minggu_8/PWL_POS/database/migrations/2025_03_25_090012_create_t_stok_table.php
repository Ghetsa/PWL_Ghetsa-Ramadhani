<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('t_stok', function (Blueprint $table) {
            $table->id('stok_id');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('barang_id');
            $table->unsignedBigInteger('user_id');
            $table->dateTime('stok_tanggal');
            $table->integer('stok_jumlah');
            $table->timestamps();

            // Pastikan foreign key mengarah ke kolom yang benar
            $table->foreign('supplier_id')->references('supplier_id')->on('m_supplier')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('t_stok');
    }
};
