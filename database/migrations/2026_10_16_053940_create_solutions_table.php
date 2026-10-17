<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solutions', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('num', 5);
            $table->string('title');
            $table->text('hero_headline');
            $table->string('badge');
            $table->text('short_desc');
            $table->text('overview');
            $table->string('image');
            $table->text('process_text')->nullable();
            $table->text('highlight_banner')->nullable();
            $table->boolean('is_published')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solutions');
    }
};
