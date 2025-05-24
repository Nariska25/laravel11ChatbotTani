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
            $table->unsignedBigInteger('user_id'); // Foreign key ke users
            $table->unsignedBigInteger('shipping_methods_id')->nullable(); // FK ke shipping_methods
            $table->unsignedBigInteger('vouchers_id')->nullable(); // FK ke vouchers
            $table->enum('order_status', ['Belum Bayar', 'Telah Dibayar', 'Sedang Dikemas', 'Dikirim', 'Selesai', 'Dibatalkan'])->default('Belum Bayar');
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('shipping_cost', 10, 2);
            $table->decimal('total_payment', 10, 2);
            $table->string('xendit_invoice_id')->nullable();
            $table->string('xendit_payment_url', 255)->nullable();
            $table->string('external_id')->nullable();
            $table->timestamp('expires_at')->nullable();

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('shipping_methods_id')->references('shipping_methods_id')->on('shipping_methods')->onDelete('set null');
            $table->foreign('vouchers_id')->references('vouchers_id')->on('vouchers')->onDelete('set null');
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
