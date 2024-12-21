<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionCalendar extends Model
{
    use HasFactory;
    protected $fillable = [
        'section_id',
        'course_id',
        'day_number',
        'start_time',
        'end_time',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
