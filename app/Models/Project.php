<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;
    

    protected $fillable = 
    [
        'user_id',
        'category_id',
        'title',
        'description',
        'text',
        'image1',
        'image2',
        'image3',
        'image4',
        'image5',
        'video',
        'goal',
        'is_active',
        'time_limit',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
