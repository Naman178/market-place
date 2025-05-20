<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = "transaction__rec_tbl";

    protected $fillable = [
        'id',
        'user_id',
        'product_id',
        'payment_status',
        'payment_amount',
        'razorpay_payment_id',
        'payment_method',
        'transaction_id',
        'sys_state',
        'currency',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'transaction_id' => 'array'
    ];

    public function product(){
        return $this->hasOne(Items::class,'id','product_id');
    }
    public function pricing()
    {
        return $this->hasOne(ItemsPricing::class, 'item_id', 'product_id');
    }
}
