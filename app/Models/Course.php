<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function videos()
    {
        return $this->hasMany(CourseVideo::class);
    }
    public function parts()
    {
        return $this->hasMany(Part::class);
    }

    public function ratings()
    {
        return $this->hasMany(CourseRating::class);
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'section_courses', 'course_id', 'section_id');
    }


    public function sectionCalendars()
    {
        return $this->hasMany(SectionCalendar::class);
    }

    public function softwaresUsages()
    {
        return $this->hasMany(inVideoUsage::class, 'course_video_id')
            ->where('type', 'software');
    }






    public function getDurationInHoursAttribute()
    {
        $totalSeconds = $this->videos()->get()->reduce(function ($carry, $video) {
            $startOfDay = \Carbon\Carbon::today(); // بداية اليوم الحالي
            $durationInSeconds = \Carbon\Carbon::parse($video->duration)->diffInSeconds($startOfDay);

            return $carry + $durationInSeconds;
        }, 0);

        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $seconds = $totalSeconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

}
