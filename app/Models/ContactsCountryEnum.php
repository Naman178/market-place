<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactsCountryEnum extends Model
{
    use HasFactory;

    protected $table = "contact_country__enum";

    protected $fillable = [
        'id',
        'name',
        'ISOname'
    ];
}
