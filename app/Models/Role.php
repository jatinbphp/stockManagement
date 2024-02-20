<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status', 'access_rights'];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    public static $status = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In Active',
    ];

    const PERMISSION_ROLES = 'roles';
    const PERMISSION_USERS = 'users';
    const PERMISSION_SUPPLIERS = 'suppliers';
    const PERMISSION_BRANDS = 'brands';
    const PERMISSION_PRACTICES = 'practices';
    const PERMISSION_STOCK_ORDERS = 'stock-orders';
    const PERMISSION_REPORTS = 'reports';

    public static $permission = [
        self::PERMISSION_ROLES => 'Roles',
        self::PERMISSION_USERS => 'Users',
        self::PERMISSION_SUPPLIERS => 'Suppliers',
        self::PERMISSION_BRANDS => 'Brands',
        self::PERMISSION_PRACTICES => 'Practices',
        self::PERMISSION_STOCK_ORDERS => 'Stock Orders',
        self::PERMISSION_REPORTS => 'Reports',
    ];
}
