<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id('vouchers_id'); // Auto-increment & Primary Key
            $table->string('promotion_code', 30)->unique(); 
            $table->dateTime('start_date');
            $table->dateTime('end_date');    
            $table->integer('quantity'); 
            $table->string('promotion_item', 250)->nullable(); 
            $table->decimal('discount', 10, 2); 
            $table->boolean('status')->default(1);
            $table->timestamps(); 
        });
    }

    public function down() {
        Schema::dropIfExists('vouchers');
    }
};