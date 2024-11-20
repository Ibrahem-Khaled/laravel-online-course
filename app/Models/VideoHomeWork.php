<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoHomeWork extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_videos_id',
        'user_id',
        'file',
        'text',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courseVideos()
    {
        return $this->belongsTo(CourseVideo::class, 'course_videos_id');
    }
}
