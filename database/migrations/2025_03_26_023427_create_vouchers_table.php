<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id('vouchers_id'); // Auto-increment & Primary Key
            $table->string('promotion_code', 50)->unique(); // Kode promosi unik
            $table->date('start_date'); // Tanggal mulai
            $table->date('end_date'); // Tanggal berakhir
            $table->time('start_time'); // Jam mulai
            $table->integer('quantity'); // Jumlah voucher
            $table->enum('promotion_type', ['percentage', 'fixed_amount']); // Jenis promo
            $table->string('promotion_item', 50)->nullable(); // Item promo (bisa null)
            $table->decimal('discount', 10, 2); // Diskon dalam desimal
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down() {
        Schema::dropIfExists('vouchers');
    }
};