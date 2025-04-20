<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id'); // Mengganti id menjadi user_id (int, auto increment)
            $table->string('name', 50); // varchar 50
            $table->string('email')->unique();
            $table->unsignedBigInteger('city_id')->nullable(); // int (nullable)
            $table->enum('role', ['user', 'admin'])->default('user'); // enum
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 250); // varchar 250
            $table->string('phone', 13)->nullable(); // varchar 13
            $table->enum('gender', ['male', 'female'])->nullable(); // enum
            $table->date('dob')->nullable(); // date
            $table->string('image_path', 250)->nullable(); // varchar 250
            $table->enum('status', ['active', 'inactive'])->default('active'); // enum
            $table->string('address', 100)->nullable(); // varchar 100
            $table->string('city', 50)->nullable(); // varchar 50
            $table->string('postal_code', 50)->nullable(); // varchar 50
            $table->string('province', 50)->nullable(); // varchar 50
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};