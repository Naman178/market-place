<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogContent extends Model
{
    use HasFactory;
    protected $table = "blog_content";

    protected $fillable = [
        'blog_id',
        'content_type',
        'content_heading',
        'content_image',
        'content_description_1',
        'content_description_2',
    ];
}
