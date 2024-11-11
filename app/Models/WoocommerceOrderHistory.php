<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WoocommerceOrderHistory extends Model
{
    use HasFactory;

    protected $table = "woocommerce_order_history__rec_tbl";

    protected $fillable = [
        'id',
        'user_id',
        'plan_id',
        'woocommerce_order_id',
        'woocommerce_order_total',
        'woocommerce_order_date',
        'woocommerce_order_url',
        'per_order_price',
        'remaining_wallet_amount',
        'created_at',
        'updated_at',
    ];

    public function plan_details() {
        return $this->hasOne(Items::class, 'id', 'plan_id')->where('sys_state','!=','-1');
    }
}
