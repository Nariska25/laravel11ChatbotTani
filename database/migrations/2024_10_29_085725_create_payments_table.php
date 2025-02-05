<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('payment_id'); // Primary key
            $table->unsignedBigInteger('order_id'); // Foreign key untuk tabel orders
            $table->date('tanggal_pembayaran'); // Tanggal pembayaran
            $table->decimal('jumlah_pembayaran', 10, 2); // Jumlah pembayaran
            $table->string('status_pembayaran'); // Status pembayaran
            $table->timestamps(); // Waktu pembuatan dan pembaruan
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments'); // Menghapus tabel jika migrasi dibatalkan
    }
};
