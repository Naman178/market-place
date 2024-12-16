<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory;
    protected $table = "share";

    protected $fillable = [
        'platfrom_name',
        'blog_id',
        'user_id',
    ];
}
