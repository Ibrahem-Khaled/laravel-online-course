<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteCourse extends Model
{
    use HasFactory;
    protected $fillable = ['route_id', 'course_id',];
}
