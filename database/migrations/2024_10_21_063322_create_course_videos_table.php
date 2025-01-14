<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->bigInteger('ranking')->nullable();
            $table->foreignId('part_id')->nullable()->constrained();
            $table->string('title');
            $table->text('video');
            $table->text('description');
            $table->text('question')->nullable();
            $table->string('image')->nullable();
            $table->integer('duration')->default(0);
            $table->enum('device', ['web', 'mobile', 'desktop', 'tablet', 'tv', 'other', 'all'])->default('web');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_videos');
    }
};
