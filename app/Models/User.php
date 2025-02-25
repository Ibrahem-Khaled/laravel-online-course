<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $appends = ['profile_image'];
    protected $guarded = ['id'];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userInfo()
    {
        return $this->hasOne(UserInfo::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'section_users', 'user_id', 'section_id');
    }

    public function videoDiscussions()
    {
        return $this->hasMany(VideoDiscussion::class);
    }
    public function userReports()
    {
        return $this->hasMany(UserRepots::class, 'user_id');
    }

    public function teacherReports()
    {
        return $this->hasMany(UserRepots::class, 'teacher_id');
    }

    public function videoHistories()
    {
        return $this->belongsToMany(CourseVideo::class, 'video_histories', 'user_id', 'course_video_id')
            ->withPivot(['completed', 'completed_at', 'last_viewed_time'])
            ->withTimestamps();
    }

    public function unreadMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id')
            ->where('is_read', false); // فقط الرسائل غير المقروءة
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'related_user_id');
    }


    //this accessors functions 
    public function getProfileImageAttribute()
    {
        return $this->image
            ? asset('storage/' . $this->image) // إذا كان هناك صورة، استخدمها
            : ($this->gender == 'female'
                ? 'https://cdn-icons-png.flaticon.com/128/2995/2995462.png'
                : 'https://cdn-icons-png.flaticon.com/128/2641/2641333.png'); // إذا لم تكن هناك صورة، اختر الصورة الافتراضية حسب الجنس
    }


}
