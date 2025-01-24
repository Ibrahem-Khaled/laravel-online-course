<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'target_group', 'description', 'image'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'route_courses', 'route_id', 'course_id');
    }

    
}
