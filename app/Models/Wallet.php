<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $table = "wallet__rec_tbl";

    protected $fillable = [
        'id',
        'user_id',
        'product_id',
        'wallet_amount',
        'total_order',
        'remaining_order',
        'created_at',
        'updated_at',        
    ];
}
