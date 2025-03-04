<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $table = 'coupons';
    protected $primaryKey = 'id';

    protected $fillable = [
        'coupon_code',
        'discount_type',
        'discount_value',
        'max_discount',
        'valid_from',
        'valid_until',
        'min_cart_amount',
        'applicable_type',
        'applicable_selection',
        'applicable_for',
        'limit_per_user',
        'total_redemptions',
        'status',
        'auto_apply',
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'applicable_selection' => 'array',
    ];
    public function usage(){
        return $this->hasMany(CouponUsages::class,'coupon_id','id');
    }
}
