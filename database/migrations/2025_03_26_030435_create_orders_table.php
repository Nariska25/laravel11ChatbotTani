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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id'); // Primary key
            $table->unsignedBigInteger('user_id'); // Menyesuaikan dengan primary key di users

            $table->enum('order_status', ['Belum Bayar', 'Telah Dibayar', 'Sedang Dikemas', 'Dikirim', 'Selesai', 'Dibatalkan'])->default('Belum Bayar');

            $table->decimal('subtotal', 10, 2); // Total price before shipping
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('shipping_cost', 10, 2); // From RajaOngkir
            $table->decimal('total_payment', 10, 2); // subtotal + shipping_cost - discount

            $table->string('courier', 50); // jne, tiki, pos, etc.
            $table->string('courier_service', 50); // REG, YES, OKE, etc.
            $table->string('delivery_estimate',50); // Estimated delivery days

            $table->text('shipping_address'); // Use text for more flexibility


            $table->string('xendit_invoice_id')->nullable(); // UUID biasanya berupa string
            $table->string('xendit_payment_url', 255)->nullable(); // Memperpanjang URL hingga 255 karakter

            $table->timestamps();

            // Tambahkan foreign key constraint
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
