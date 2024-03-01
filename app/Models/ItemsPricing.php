<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemsPricing extends Model
{
    use HasFactory;
    protected $table = 'items_pricing__tbl';
    protected $fillable = ['item_id', 'fixed_price', 'sale_price', 'gst_percentage', 'created_at', 'updated_at'];

    public function item()
    {
        return $this->belongsTo(Items::class);
    }
}
