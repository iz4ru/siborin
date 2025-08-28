<?php

// database/migrations/2025_08_28_000000_create_options_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('show_images')->default(true);
            $table->boolean('show_videos')->default(true);
            $table->boolean('show_musics')->default(true);
            $table->boolean('show_texts')->default(true);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('options');
    }
};