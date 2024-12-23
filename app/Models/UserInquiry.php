<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInquiry extends Model
{
    use HasFactory;

    protected $table = "user_inquiry__rec_tbl";

    protected $fillable = [
        'id',
        'full_name',
        'email',
        'contact_number',
        'website_url',
        'message',
        'stack',
        'created_at',
        'updated_at',
    ];
}
