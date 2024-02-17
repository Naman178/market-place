<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    
    protected $table = "settings__tbl";

    protected $fillable = [
        'key',
        'value',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'value' => 'array'
    ];
}
