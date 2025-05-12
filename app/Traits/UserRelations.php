<?php

namespace App\Traits;

use App\Models\Course;
use App\Models\CourseVideo;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Section;
use App\Models\UserInfo;
use App\Models\UserRepots;
use App\Models\VideoDiscussion;

trait UserRelations
{
    public function userInfo()
    {
        return $this->hasOne(UserInfo::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'section_users', 'user_id', 'section_id')
            ->where('type', 'ambitious_program');
    }
    public function entrepreneurshipPrograms()
    {
        return $this->belongsToMany(Section::class, 'section_users', 'user_id', 'section_id')
            ->where('type', 'entrepreneurship_program');
    }
    public function videoDiscussions()
    {
        return $this->hasMany(VideoDiscussion::class);
    }
    public function userReports()
    {
        return $this->hasMany(UserRepots::class, 'user_id');
    }

    public function teacherReports()
    {
        return $this->hasMany(UserRepots::class, 'teacher_id');
    }

    public function videoHistories()
    {
        return $this->belongsToMany(CourseVideo::class, 'video_histories', 'user_id', 'course_video_id')
            ->withPivot(['completed', 'completed_at', 'last_viewed_time'])
            ->withTimestamps();
    }

    public function unreadMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id')
            ->where('is_read', false); // فقط الرسائل غير المقروءة
    }

    public function user_notifications()
    {
        return $this->hasMany(Notification::class, 'related_user_id');
    }

    public function CoursesSubscriptions()
    {
        return $this->belongsToMany(Course::class, 'user_courses', 'user_id', 'course_id')
            ->withPivot(['is_active'])
            ->withTimestamps();
    }
}
