<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        // Membuat tabel products
        Schema::create('products', function (Blueprint $table) {
            $table->id('produk_id');
            $table->string('nama_produk');
            $table->text('deskripsi_produk')->nullable();
            $table->decimal('harga', 10, 2);
            $table->integer('stok');
            $table->unsignedBigInteger('kategori_id'); // Definisi foreign key

            // Menambahkan foreign key
            $table->foreign('kategori_id')->references('kategori_id')->on('categories')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        // Menghapus foreign key dan tabel products
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']); // Hapus foreign key jika ada
        });

        Schema::dropIfExists('products');
    }
}
