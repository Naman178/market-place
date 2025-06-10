<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Usamamuneerchaudhary\Commentify\Models\Comment;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',     
        'title',
        'content',
        'image',
    ];
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
}
