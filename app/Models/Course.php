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
        'duration_in_hours',
        'language',
        'status',
        'is_featured',
        'slug',
        'meta_title',
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

    public function requirements()
    {
        return $this->hasMany(inVideoUsage::class, 'course_video_id')
            ->where('type', 'software');
    }
}
