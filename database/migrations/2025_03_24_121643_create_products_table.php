<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('products_id'); // Perbaikan primary key
            $table->string('products_name', 250);
            $table->string('products_image', 250);
            $table->longText('products_description')->nullable(); // Menggunakan string agar sesuai dengan varchar(100)
            $table->decimal('price', 10, 2);
            $table->integer('stock');
            $table->integer('recommendation')->default(0); // Tambahkan default agar lebih aman
            $table->unsignedBigInteger('category_id');

            // Menambahkan foreign key dengan cascade delete
            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
