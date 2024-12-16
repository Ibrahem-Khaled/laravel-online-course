<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inVideoUsage extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'course_video_id',
        'title',
        'type',
        'description',
        'image',
        'file',
    ]; 

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function video()
    {
        return $this->belongsTo(CourseVideo::class);
    }
}
