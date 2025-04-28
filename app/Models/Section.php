<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Section extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'type', 'image', 'meeting_link'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'section_users', 'section_id', 'user_id');
    }

    // جلب الطلاب فقط الذين دورهم student
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'section_users', 'section_id', 'user_id')
            ->withTimestamps()
            ->where('users.role', 'student');
    }

    // جلب المعلمين فقط الذين دورهم teacher
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'section_users', 'section_id', 'user_id')
            ->withTimestamps()
            ->where('users.role', 'teacher');
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
