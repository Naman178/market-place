<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionRec extends Model
{
    use HasFactory;
    protected $table = 'subscription_rec_tbl';
    protected $fillable = [
        'user_id',
        'product_id',
        'order_id',
        'invoice_id',
        'key_id',
        'status',
    ];
    public function invoice(){
        return $this->hasOne(InvoiceModel::class, 'id', 'invoice_id');
    }
    public function product(){
        return $this->hasOne(Items::class,'id','product_id');
    }
    public function key(){
        return $this->hasOne(Key::class,'id','key_id');
    }
}
