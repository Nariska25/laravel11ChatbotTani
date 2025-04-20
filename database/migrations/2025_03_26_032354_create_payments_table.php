<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id'); // Primary key, auto-increment
            $table->unsignedBigInteger('order_id'); // Foreign key ke orders
            $table->string('xendit_invoice_id', 50)->unique(); // ID dari Xendit, dibatasi 50 karakter
            $table->enum('payment_method', ['Virtual Account', 'QRIS', 'e-Wallet']);
            $table->decimal('amount', 10, 2); // Jumlah pembayaran
            $table->enum('status', ['Pending', 'Dikonfirmasi', 'Expired', 'Gagal'])->default('Pending');
            $table->timestamp('paid_at')->nullable(); // Waktu pembayaran
            $table->timestamps();

            // Foreign key untuk orders
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
