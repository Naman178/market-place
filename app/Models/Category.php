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
        'updated_at'
    ];

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    }
}
