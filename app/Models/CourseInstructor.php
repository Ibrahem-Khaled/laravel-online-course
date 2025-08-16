<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseInstructor extends Model
{
    protected $fillable = [
        'course_id',
        'user_id',
        'role',
    ];

    // علاقة مع الكورس
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // علاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
