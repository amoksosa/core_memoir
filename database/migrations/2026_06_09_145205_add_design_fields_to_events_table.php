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
    Schema::table('events', function (Blueprint $table) {
        $table->string('theme')->default('classic')->after('is_active');
        $table->text('background_image')->nullable()->after('theme');
        $table->string('background_photographer')->nullable()->after('background_image');
        $table->text('background_photographer_url')->nullable()->after('background_photographer');
    });
}

public function down(): void
{
    Schema::table('events', function (Blueprint $table) {
        $table->dropColumn([
            'theme',
            'background_image',
            'background_photographer',
            'background_photographer_url',
        ]);
    });
}
};
