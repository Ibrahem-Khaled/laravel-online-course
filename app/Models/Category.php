<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'status',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function subCategories()
    {
        return $this->hasMany(subCategory::class);
    }
}
