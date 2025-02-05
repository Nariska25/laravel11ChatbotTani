<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->increments('carts_id'); // Primary key untuk tabel carts
            $table->unsignedBigInteger('produk_id'); // Foreign key ke tabel produk
            $table->unsignedBigInteger('order_id'); // Foreign key ke tabel orders
            $table->integer('jumlah'); // Jumlah produk dalam keranjang
            $table->timestamps();
        
            // Tambahkan foreign key constraints
            $table->foreign('produk_id')->references('produk_id')->on('products')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('carts'); // Menghapus tabel jika migrasi dibatalkan
    }
};
