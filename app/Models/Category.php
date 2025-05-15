<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = "categories__tbl";

    protected $fillable = [
        'name',
        'image',
        'sys_state',
        'created_at',
        'updated_at',
        'slug',
    ];

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    }
    public function items()
    {
        return $this->hasMany(ItemsCategorySubcategory::class, 'category_id', 'id');
    }
}
