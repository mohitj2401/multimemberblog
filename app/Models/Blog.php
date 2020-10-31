<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;


    protected $fillable = [
        'title', 'image', 'content','slug','category','tags'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function like()
    {
        return $this->hasMany(Like::class);
    }

    public function tags()
    {
     return $this->belongsToMany(
            Tag::class,
            'tags_blogs',
            'blog_id',
            'tag_id');
    }
    public function category()
    {
     return $this->belongsToMany(
            Category::class,
            'categories_blogs',
            'blog_id',
            'category_id');
    }
}
