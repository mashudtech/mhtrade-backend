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
            $table->string('image')->nullable()->change();
        });

        Schema::table('solution_items', function (Blueprint $table) {
            if (! Schema::hasColumn('solution_items', 'image')) {
                $table->string('image')->nullable()->after('desc');
            }
            $table->string('subtitle')->nullable()->change();
            $table->text('details')->nullable()->change();
            $table->text('summary')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solution_items', function (Blueprint $table) {
            if (Schema::hasColumn('solution_items', 'image')) {
                $table->dropColumn('image');
            }
            $table->string('subtitle')->nullable(false)->change();
            $table->text('details')->nullable(false)->change();
            $table->text('summary')->nullable(false)->change();
        });

        Schema::table('solutions', function (Blueprint $table) {
            $table->string('image')->nullable(false)->change();
        });
    }
};
