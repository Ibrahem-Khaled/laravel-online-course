<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseVideo extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id',
        'title',
        'video',
        'description',
        'image',
        'question',
    ];

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
}
