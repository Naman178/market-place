<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;
    protected $table = 'items__tbl';
    protected $fillable = [
        'name',
        'html_description',
        'thumbnail_image',
        'main_file_zip',
        'preview_url',
        'status',
        'category_id',
        'sub_category_id',
        'created_at',
        'updated_at',
        'sys_state',
        'trial_days',
    ];

    public function features() {
        return $this->hasMany(ItemsFeature::class, 'item_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(ItemsImage::class, 'item_id', 'id');
    }

    public function tags()
    {
        return $this->hasMany(ItemsTag::class, 'item_id', 'id');
    }

    public function categorySubcategory()
    {
        return $this->hasOne(ItemsCategorySubcategory::class, 'item_id', 'id');
    }

    public function pricing()
    {
        return $this->hasOne(ItemsPricing::class, 'item_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(Reviews::class, 'item_id');
    }
    public function order(){
        return $this->hasMany(Order::class, 'product_id');
    }
}
