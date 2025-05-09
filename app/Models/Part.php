<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'name',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function videos()
    {
        return $this->hasMany(CourseVideo::class);
    }
}
