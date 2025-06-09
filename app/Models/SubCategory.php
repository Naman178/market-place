<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $table = "sub_categories__tbl";

    protected $fillable = [
        'category_id',
        'name',
        'image',
        'sys_state',
        'created_at',
        'updated_at',
        'slug'
    ];

     public function items()
    {
        return $this->hasMany(ItemsCategorySubcategory::class, 'category_id', 'id');
    }
}
