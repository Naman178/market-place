<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponUsages extends Model
{
    use HasFactory;

    protected $table = 'coupon_usages';
    protected $primaryKey = 'id';
    protected $fillable = [
        'coupon_id',
        'user_id',
        'order_id',
        'discount_value',
    ];
}
