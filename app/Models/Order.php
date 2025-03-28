<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $table = "order__rec_tbl";

    protected $fillable = [
        'id',
        'product_id',
        'user_id',
        'payment_status',
        'payment_amount',
        'razorpay_payment_id',
        'payment_method',
        'transaction_id',
        'order_count',
        'order_limit',
        'sys_state',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'transaction_id' => 'array'
    ];

    public function product(){
        return $this->hasOne(Items::class,'id','product_id');
    }

    public function key(){
        return $this->hasOne(Key::class,'order_id','id');
    }
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
    public function invoice(){
        return $this->HasOne(InvoiceModel::class, "orderid" , 'id');
    }
    public function transaction(){
        return $this->hasOne(Transaction::class,'id','transaction_id');
    }
}
