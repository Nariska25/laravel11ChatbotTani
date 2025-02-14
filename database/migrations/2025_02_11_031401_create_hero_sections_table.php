<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('hero_sections', function (Blueprint $table) {
            $table->string('image')->nullable()->after('id');
            $table->string('title');
            $table->text('description');
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('hero_sections', function (Blueprint $table) {
            $table->dropColumn(['image', 'title', 'description', 'is_active']);
        });
    }
};
