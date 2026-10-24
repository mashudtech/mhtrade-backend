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
        Schema::table('solutions', function (Blueprint $table) {
            $table->string('inquiry_prefix', 20)->nullable()->after('num');
            $table->unsignedInteger('inquiry_start_number')->default(1000)->after('inquiry_prefix');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solutions', function (Blueprint $table) {
            $table->dropColumn(['inquiry_prefix', 'inquiry_start_number']);
        });
    }
};
