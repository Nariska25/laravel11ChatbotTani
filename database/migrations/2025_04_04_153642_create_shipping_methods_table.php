<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id('shipping_methods_id'); // Primary key
            $table->string('courier');
            $table->string('courier_service');
            $table->string('delivery_estimate');
            $table->integer('cost');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_methods');
    }
};
