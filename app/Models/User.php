<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\UserRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, UserRelations;
    protected $appends = ['profile_image'];
    protected $guarded = ['id'];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
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
