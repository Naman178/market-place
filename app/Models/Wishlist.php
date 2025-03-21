<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $table = 'wishlist';

    protected $fillable = [
        'user_id',
        'product_id',
    ];
    public function plan()
    {
        return $this->hasMany(Items::class, 'id', 'product_id');
    }
    public function pricing()
    {
        return $this->hasOne(ItemsPricing::class, 'item_id', 'product_id');
    }
}
