<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemsTag extends Model
{
    use HasFactory;
    protected $fillable = ['item_id', 'tag_name', 'created_at', 'updated_at'];

    public function item()
    {
        return $this->belongsTo(Items::class);
    }
}
