<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
   
    protected $fillable = ['name', 'email', 'password', 'role', 'image', 'phone', 'status', 'practice_ids'];

    public function role(){
        return $this->belongsTo(Role::class, 'role', 'alias');
    }
   
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    public static $status = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In Active',
    ];

    /* user roles */
    const STOCK_CLERK = "stock_clerk";
    const ACCOUNTANT = "accountant";
    const MAIN_ADMIN = "admin";
    const SUPER_ADMIN = "super_admin";
    const GENERAL_ADMIN = "general_admin";
    const SHOP_MANAGER  = "shop_manager";

    public static $roles = [
        self::ACCOUNTANT => "Accountant",
        self::MAIN_ADMIN => "Receiving Admin",
        self::GENERAL_ADMIN => "General Admin",
        self::STOCK_CLERK => "Stock Clerk",
        self::SHOP_MANAGER => "Shop Manager",
    ];
}
