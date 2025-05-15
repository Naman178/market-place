<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Usamamuneerchaudhary\Commentify\Http\Livewire\Comments;

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
        'slug',
    ];
    
    public function relatedBlogs()
    {
        return Blog::whereIn('blog_id', json_decode($this->related_blogs, true) ?? [])->get();
    }
    public function categoryname()
    {
        return $this->hasOne(Blog_category::class, 'category_id', 'category');
    }
    public function comments(): MorphMany
    {
        return $this->morphMany(Comments::class, 'commentable');
    }
}
