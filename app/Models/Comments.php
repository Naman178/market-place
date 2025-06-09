<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Usamamuneerchaudhary\Commentify\Traits\Commentable;

class Comments extends Model
{
    use HasFactory;
    use Commentable;
    protected $table = "comments";

    protected $fillable = [
        'blog_id ',
        'user_id ',
        'description',
        'item_id',
        'title',
        'image',
        'post_id'
    ];
    public function user() {
        return $this->belongsTo(User::class); 
    }
    public function commentable()
    {
        return $this->morphTo();
    }
}
