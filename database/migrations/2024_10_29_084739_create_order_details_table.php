<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->increments('detail_id', true); // Menggunakan increments untuk detail_id
            $table->unsignedBigInteger('order_id'); // Menggunakan unsignedBigInteger untuk order_id
            $table->unsignedBigInteger('product_id'); // Menggunakan unsignedBigInteger untuk product_id
            $table->integer('jumlah_produk');
            $table->decimal('harga_satuan', 10, 2);
            $table->decimal('total_harga', 10, 2);
            $table->timestamps(); // Menggunakan timestamps default
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_details');
    }
};
