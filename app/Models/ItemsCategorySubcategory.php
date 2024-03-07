<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemsCategorySubcategory extends Model
{
    use HasFactory;
    protected $table = 'items_category_subcategories__tbl';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = [
        'item_id',
        'category_id',
        'subcategory_id',
    ];

    public $timestamps = true;

    // Define relationships if needed
    public function item()
    {
        return $this->belongsTo(Items::class, 'item_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }
}
