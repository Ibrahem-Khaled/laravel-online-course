<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseVideo extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id',
        'part_id',
        'title',
        'video',
        'description',
        'image',
        'question',
        'duration',
        'device',
    ];

    protected $casts = [
        'duration' => 'datetime:H:i:s', // للتأكد من التخزين بصيغة صحيحة
    ];

    // إنشاء Accessor للحصول على الوقت فقط
    public function getDurationAttribute($value)
    {
        // تقسيم السلسلة إلى أجزاء باستخدام الفاصل (:)
        $parts = explode(':', $value);

        if (count($parts) === 3) {
            $hours = (int) $parts[0];
            $minutes = (int) $parts[1];
            $seconds = (int) $parts[2];

            // إنشاء فترة زمنية باستخدام CarbonInterval
            $interval = \Carbon\CarbonInterval::hours($hours)
                ->minutes($minutes)
                ->seconds($seconds);

            // يمكنك استخدام cascade() لتعديل القيم إلى الشكل المطلوب إذا كانت هناك قيم تتعدى الحدود القياسية
            return $interval->cascade()->format('%H:%I:%S');
        }

        return $value;
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function homeWorks()
    {
        return $this->hasMany(VideoHomeWork::class, 'course_videos_id');
    }

    public function videoDiscussions()
    {
        return $this->hasMany(VideoDiscussion::class);
    }

    public function videoUsage()
    {
        return $this->hasMany(inVideoUsage::class);
    }
    public function histories()
    {
        return $this->belongsToMany(User::class, 'video_histories', 'course_video_id', 'user_id')
            ->withPivot(['completed', 'completed_at', 'last_viewed_time'])
            ->withTimestamps();
    }

    public function part()
    {
        return $this->belongsTo(Part::class);
    }
}
