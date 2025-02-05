<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('products', function (Blueprint $table) {
        $table->unsignedBigInteger('kategori_id')->nullable()->change(); // Mengubah kategori_id menjadi nullable
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        $table->unsignedBigInteger('kategori_id')->nullable(false)->change(); // Kembalikan ke non-nullable
    });
}

};
