<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('template')->default('classic')->after('theme');
            $table->string('photo_frame')->default('polaroid')->after('template');
            $table->string('font_style')->default('modern')->after('photo_frame');
            $table->text('caption')->nullable()->after('font_style');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'template',
                'photo_frame',
                'font_style',
                'caption',
            ]);
        });
    }
};