<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemsFeature extends Model
{
    use HasFactory;
    protected $table = 'items_features__tbl';
    protected $fillable = ['item_id', 'key_feature', 'created_at', 'updated_at'];

    public function item()
    {
        return $this->belongsTo(Items::class);
    }
}
