<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'type', 'image', 'meeting_link'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'section_users', 'section_id', 'user_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'section_courses', 'section_id', 'course_id');
    }
    public function calendars()
    {
        return $this->hasMany(SectionCalendar::class);
    }
}
