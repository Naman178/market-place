<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'lname',
        'fname',
        'email',
        'status',
        'password',
        "address_line1",
        "address_line2",
        "company_website",
        "country",
        "company_name",
        "contact_number",
        "country_code",
        "sys_state",
        "created_at",
        "updated_at",
        "postal_code",
        "city",
        "profile_pic",
        "subscribe_to_promotions",
        'country_name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function avatar()
    {
        return filter_var($this->profile_pic, FILTER_VALIDATE_URL) 
            ? $this->profile_pic 
            : asset('assets/images/faces/' . $this->profile_pic);
    }
}
