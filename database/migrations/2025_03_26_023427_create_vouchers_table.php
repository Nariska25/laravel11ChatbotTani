<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id('vouchers_id'); // Auto-increment & Primary Key
            $table->string('promotion_code', 50)->unique(); 
            $table->date('start_date'); 
            $table->date('end_date'); 
            $table->time('start_time'); 
            $table->integer('quantity'); 
            $table->enum('promotion_type', ['percentage', 'fixed_amount']); // Jenis promo
            $table->string('promotion_item', 250)->nullable(); 
            $table->decimal('discount', 10, 2); 
            $table->timestamps(); 
        });
    }

    public function down() {
        Schema::dropIfExists('vouchers');
    }
};