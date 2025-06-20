<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Usamamuneerchaudhary\Commentify\Models\Comment;

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
        'currency',
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
        return $this->hasMany(Reviews::class, 'item_id')->where('sys_state', '0');
    }
    public function order(){
        return $this->hasMany(Order::class, 'product_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }
}
