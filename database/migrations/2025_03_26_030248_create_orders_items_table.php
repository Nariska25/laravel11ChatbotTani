<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id('order_item_id'); // Primary key
            $table->unsignedBigInteger('order_id'); // Foreign key ke orders
            $table->unsignedBigInteger('products_id'); // Foreign key ke products
            $table->integer('amount'); // Jumlah produk
            $table->decimal('subtotal', 10, 2); // Subtotal = amount * price
            $table->timestamps();

            // Foreign key untuk orders
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');

            // Foreign key untuk products
            $table->foreign('products_id')->references('products_id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
