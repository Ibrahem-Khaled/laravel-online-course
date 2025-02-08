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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // صاحب الإشعار
            $table->foreignId('related_user_id')->nullable()->constrained('users')->onDelete('cascade'); // المرسل إليه (اختياري)
            $table->string('type'); // نوع الإشعار مثل "comment", "assignment", "message"
            $table->text('message'); // محتوى الإشعار
            $table->boolean('is_read')->default(false); // حالة قراءة الإشعار
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
