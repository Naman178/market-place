<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemsImage extends Model
{
    use HasFactory;
    protected $table = 'items_images__tbl';
    protected $fillable = ['item_id', 'image_path', 'created_at', 'updated_at'];

    public function item()
    {
        return $this->belongsTo(Items::class);
    }
}
