<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    use HasFactory;
    protected $table = "addon__rec_tbl";

    protected $fillable = [
        'id',
        'upload_category',
        'addon_name',
        'addon_slug',
        'key_features',
        'html_description',
        'thumbnail',
        'main_file',
        'addon_category',
        'tags',
        'regular_price',
        'sys_state',
        'created_by',
        'created_at',
        'updated_at',
    ];
    
    public function prod_cat() {
        return $this->hasOne(ItemsCategorySubcategory::class, 'id', 'addon_category')->where('sys_state','!=','-1');
    }
}
