<?php

namespace App\Models;

use App\Traits\CourseRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory, CourseRelations;
    protected $appends = [
        'duration_in_hours',
        'user_subscription_from_this_course',
    ];
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'price',
        'image',
        'difficulty_level',
        'language',
        'status',
        'is_featured',
        'slug',
        'meta_title',
        'type',
        'meta_description',
        'published_at',
    ];


    public function instructors()
    {
        return $this->belongsToMany(User::class, 'course_instructors')
            ->withPivot('role')
            ->withTimestamps();
    }

    //this accessors functions
    public function getDurationInHoursAttribute()
    {
        // 1) نجمع ثواني كل الفيديوهات
        $totalSeconds = $this->videos->sum(function ($video) {
            // قسّم السلسلة ثم اعكس الترتيب: [الثواني, الدقائق, الساعات]
            $segments = array_reverse(explode(':', $video->duration));

            // استخدم isset أو ?? للحصول على قيمة أو صفر إذا لم توجد
            $seconds = isset($segments[0]) ? (int) $segments[0] : 0;
            $minutes = isset($segments[1]) ? (int) $segments[1] : 0;
            $hours = isset($segments[2]) ? (int) $segments[2] : 0;

            return $hours * 3600 + $minutes * 60 + $seconds;
        });

        // 2) نحسب الساعات والدقائق والثواني من المجموع
        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $seconds = $totalSeconds % 60;

        // 3) نعيد الصيغة HH:MM:SS
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    public function getUserSubscriptionFromThisCourseAttribute()
    {
        return $this->userSubscription()
            ->where('user_id', auth()->id())
            ->first() ? true : false;
    }
}
