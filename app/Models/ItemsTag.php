<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemsTag extends Model
{
    use HasFactory;
    protected $table = 'items_tags__tbl';
    protected $fillable = ['item_id', 'tag_name', 'created_at', 'updated_at'];

    public function item()
    {
        return $this->belongsTo(Items::class, 'item_id', 'id');
    }
}
