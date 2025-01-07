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
        Schema::create('courses', function (Blueprint $table) {
            $table->id(); // المعرف الأساسي للدورة
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // معرف المستخدم (علاقة مع جدول المستخدمين)
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // معرف الفئة (علاقة مع جدول الفئات)

            // معلومات الدورة الأساسية
            $table->string('title')->index(); // العنوان (مفهرس لتحسين الأداء)
            $table->text('description')->nullable(); // وصف الدورة
            $table->float('price', 8, 2)->default(0.00); // السعر مع دقة (8 أرقام، رقمين عشريين)
            $table->string('image')->nullable(); // رابط أو مسار الصورة

            // معلومات إضافية
            $table->enum('difficulty_level', ['beginner', 'intermediate', 'advanced'])->default('beginner'); // مستوى الصعوبة
            $table->string('language', 50)->default('English'); // لغة الدورة

            // حالة الدورة وتوفرها
            $table->enum('status', ['active', 'inactive', 'draft'])->default('active'); // حالة الدورة
            $table->boolean('is_featured')->default(false); // هل الدورة مميزة؟

            // الحقول المتعلقة بـ SEO
            // $table->string('slug')->unique(); // رابط URL صديق لمحركات البحث
            //  $table->string('meta_title')->nullable(); // عنوان SEO
            //  $table->text('meta_description')->nullable(); // وصف SEO

            // التواريخ والمتابعة
            $table->timestamp('published_at')->nullable(); // تاريخ النشر
            $table->timestamps(); // حقول created_at و updated_at
            $table->softDeletes(); // الحذف الناعم
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
