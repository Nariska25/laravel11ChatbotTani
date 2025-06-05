<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts_detail', function (Blueprint $table) {
            $table->id('carts_detail_id');
            $table->unsignedBigInteger('carts_id');
            $table->unsignedBigInteger('products_id');
            $table->integer('amount'); // Jumlah produk
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();

            // Relasi (opsional, jika ada foreign key)
            $table->foreign('carts_id')->references('carts_id')->on('carts')->onDelete('cascade');
            $table->foreign('products_id')->references('products_id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts_detail');
    }
};
