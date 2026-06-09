<?php

use App\Models\Event;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_guests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Event::class)->constrained()->cascadeOnDelete();
            $table->string('guest_token')->unique();
            $table->string('guest_name')->nullable();
            $table->timestamps();

            $table->unique(['event_id', 'guest_token']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_guests');
    }
};