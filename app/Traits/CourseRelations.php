<?php

namespace App\Traits;

use App\Models\Category;
use App\Models\CourseRating;
use App\Models\CourseVideo;
use App\Models\inVideoUsage;
use App\Models\Part;
use App\Models\Section;
use App\Models\SectionCalendar;
use App\Models\User;

trait CourseRelations
{
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

    public function userSubscription()
    {
        return $this->belongsToMany(User::class, 'user_courses', 'course_id', 'user_id')
            ->withPivot('is_active')
            ->withTimestamps();
    }
}
