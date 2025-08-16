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
        Schema::create('course_instructors', function (Blueprint $table) {
            $table->id();

            // علاقة مع الكورسات
            $table->foreignId('course_id')
                ->constrained('courses')
                ->onDelete('cascade');

            // علاقة مع المستخدمين (المدربين)
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // نوع المدرب (مساعد - شريك ...)
            $table->enum('role', ['assistant', 'co-trainer'])->default('assistant');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_instructors');
    }
};
