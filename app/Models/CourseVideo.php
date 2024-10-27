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
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
