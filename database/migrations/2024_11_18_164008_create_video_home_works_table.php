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
        Schema::create('video_home_works', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('course_videos_id')->unsigned();
            $table->foreign('course_videos_id')->references('id')->on('course_videos')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('file')->nullable();
            $table->string('text')->required();
            $table->integer('rating')->nullable();
            $table->string('reply')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_home_works');
    }
};
