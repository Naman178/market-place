<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;
    protected $table = "reviews__tbl";

    protected $fillable = [
        'item_id',
        'user_id',
        'rating',
        'review',
        'status',
        'sys_state',
        'created_at',
        'updated_at'
    ];

    public function item()
    {
        return $this->belongsTo(Items::class, 'item_id');
    }
    public function user() {
        return $this->belongsTo(User::class); 
    }
}
