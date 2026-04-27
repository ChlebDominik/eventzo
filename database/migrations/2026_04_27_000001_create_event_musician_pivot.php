<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Drop the old single musician_id column if it exists
        if (Schema::hasColumn('events', 'musician_id')) {
            Schema::table('events', function (Blueprint $table) {
                $table->dropForeign(['musician_id']);
                $table->dropColumn('musician_id');
            });
        }

        // Create pivot table for many-to-many
        Schema::create('event_musician', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('musician_id')->constrained()->cascadeOnDelete();
            $table->integer('order')->default(0); // display order
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_musician');
        Schema::table('events', function (Blueprint $table) {
            $table->foreignId('musician_id')->nullable()->after('image')->constrained()->nullOnDelete();
        });
    }
};
