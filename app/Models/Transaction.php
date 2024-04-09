<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = "transactions";

    protected $fillable = [
        "id",
        "user_id",
        "order_id",
        "status",
        "amount",
        "created_at",
        "updated_at",
    ];
}
