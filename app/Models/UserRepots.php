<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRepots extends Model
{
    use HasFactory;
    protected $filable = [
        'user_id',
        'teacher_id',
        'attendance',
        'reactivity',
        'homework',
        'completion',
        'creativity',
        'ethics',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }


    //this functions accessor
    public function getTotalAttribute()
    {
        return $this->attendance +
            $this->reactivity +
            $this->homework +
            $this->completion +
            $this->creativity +
            $this->ethics;
    }
}
