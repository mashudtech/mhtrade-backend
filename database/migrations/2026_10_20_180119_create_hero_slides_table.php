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
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('tag')->nullable();
            $table->string('title');
            $table->string('title_accent')->nullable();
            $table->text('subtitle')->nullable();
            $table->string('button_text')->nullable()->default('Submit Requirement');
            $table->string('button_link')->nullable();
            $table->string('button_vertical')->nullable()->default('general');
            $table->string('background_image')->nullable();
            $table->integer('order_index')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
