<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('carts_id'); // Primary key untuk tabel carts (auto-increment)
            $table->unsignedBigInteger('products_id'); // Foreign key ke tabel products
            $table->unsignedBigInteger('user_id'); // Foreign key ke tabel users
            $table->integer('amount'); // Jumlah produk dalam keranjang
            $table->decimal('discount', 10, 2)->default(0);// Diskon dengan 2 desimal (contoh: 10.50)
            $table->decimal('subtotal', 10, 2); // Subtotal dengan 2 desimal (contoh: 1500.75)
            $table->decimal('total', 10, 2); // Total dengan 2 desimal (contoh: 1450.25)
            $table->timestamps();

            // Tambahkan foreign key constraints
            $table->foreign('products_id')->references('products_id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('carts'); // Menghapus tabel jika migrasi dibatalkan
    }
};
