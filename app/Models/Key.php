<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    use HasFactory;
    
    protected $table = "key__rec_tbl";

    protected $fillable = [
        'id',
        'key',
        'user_id',
        'order_id',
        'product_id',
        'creared_at',
        'expire_at',
        'key_used_limit',
        'sys_state',
        'created_at',
        'updated_at',
    ];
}
