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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('slug');
            $table->unsignedInteger('order_column')->default(1);
            $table->unsignedInteger('duration_minutes')->default(0);
            $table->string('video_url')->nullable();
            $table->string('attachment_path')->nullable();
            $table->boolean('is_free_preview')->default(false);
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->unique(['course_id', 'slug']);
            $table->unique(['course_id', 'order_column']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
