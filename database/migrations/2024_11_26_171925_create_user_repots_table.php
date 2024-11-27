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
        Schema::create('user_repots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('teacher_id');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('attendance')->default(0)->max(10)->nullable();
            $table->integer('reactivity')->default(0)->max(10)->nullable();
            $table->integer('homework')->default(0)->max(10)->nullable();
            $table->integer('completion')->default(0)->max(10)->nullable();
            $table->integer('creativity')->default(0)->max(10)->nullable();
            $table->integer('ethics')->default(0)->max(10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_repots');
    }
};
