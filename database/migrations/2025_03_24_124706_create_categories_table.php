<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        // Membuat tabel categories
        Schema::create('categories', function (Blueprint $table) {
            $table->id('category_id'); // Primary key, auto-increment
            $table->string('category_name', 50); // varchar(50)
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
