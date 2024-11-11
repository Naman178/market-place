<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCustomer extends Model
{
    use HasFactory;

    protected $table = "user_customer__rec_tbl";

    protected $fillable = [
        'id',
        'contact_number',
        'email',
        'register_under_user_id',
        'site_url',
        'created_at',
        'updated_at',
    ];

    public function user(){
        return $this->hasOne(User::class,'id','register_under_user_id');
    }

}
