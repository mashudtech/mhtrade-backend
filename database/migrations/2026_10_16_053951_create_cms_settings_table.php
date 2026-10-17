<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cms_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('label')->nullable();          // Human-readable label for admin UI
            $table->string('group')->default('general');  // general|contact|smtp|social
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_settings');
    }
};
