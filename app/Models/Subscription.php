<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $table = 'subscription';
    protected $fillable = [
        'user_id',
        'subscription_id',
        'product_id',
        'status',
        'key_id'
    ];
    public function product(){
        return $this->hasOne(Items::class,'id','product_id');
    }
}
