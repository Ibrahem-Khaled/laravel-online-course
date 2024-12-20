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
        Schema::create('section_calendars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained();
            $table->foreignId('course_id')->constrained();
            $table->integer('day_number')->required()->max(7);
            $table->time('start_time')->required();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_calendars');
    }
};
