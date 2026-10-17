<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('request_id', 30)->unique(); // e.g. MH-LC-00001
            $table->string('vertical', 50);             // lc|uae-banking|project|commodity|general
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('position')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('country')->nullable();
            $table->text('details')->nullable();
            $table->string('doc_path')->nullable();     // uploaded file path in storage/
            $table->enum('status', [
                'new', 'in_review', 'information_required', 'processing', 'completed', 'closed'
            ])->default('new');
            $table->text('internal_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
