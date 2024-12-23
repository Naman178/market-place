<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $table = "blog";
    protected $primaryKey = 'blog_id'; 

    protected $fillable = [
        'title',
        'category',
        'image',
        'short_description',
        'long_description',
        'related_blogs',
        'status',
        'uploaded_by',
    ];
    
    public function relatedBlogs()
    {
        return Blog::whereIn('blog_id', json_decode($this->related_blogs, true) ?? [])->get();
    }
}
