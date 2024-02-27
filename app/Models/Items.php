<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;
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
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function features()
    {
        return $this->hasMany(ItemsFeature::class);
    }

    public function images()
    {
        return $this->hasMany(ItemsImage::class);
    }

    public function tags()
    {
        return $this->hasMany(ItemsTag::class);
    }

    public function pricing()
    {
        return $this->hasOne(ItemsPricing::class);
    }
}
