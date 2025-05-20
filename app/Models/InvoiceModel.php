<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceModel extends Model
{
    use HasFactory;
    protected $table = 'invoice';
    protected $fillable = [
        'orderid',
        'user_id',
        'transaction_id',
        'invoice_number',
        'subtotal',
        'gst_percentage',
        'discount_type',
        'discount',
        'applied_coupon',
        'total',
        'payment_method',
        'payment_status',
        'product_id',
        'quantity'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'orderid');
    }
    public function coupon(){
        return $this->hasOne(Coupon::class,'id' , 'applied_coupon');
    }
    public function product(){
        return $this->hasOne(Items::class,'id','product_id');
    }
    public function transaction(){
        return $this->hasOne(Transaction::class,'id','transaction_id');
    }

    public function pricing()
    {
        return $this->hasOne(ItemsPricing::class, 'item_id', 'product_id');
    }
}
