<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemsPricing extends Model
{
    use HasFactory;
    protected $table = 'items_pricing__tbl';
    protected $fillable = ['item_id','pricing_type','billing_cycle','custom_cycle_days','auto_renew','grace_period','expiry_date','fixed_price', 'sale_price', 'gst_percentage', 'created_at', 'updated_at','validity','sub_id'];

    public function item()
    {
        return $this->belongsTo(Items::class, 'item_id', 'id');
    }
}
