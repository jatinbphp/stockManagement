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
    const PERMISSION_STOCK_ORDERS_ADD = 'stock-orders-add';
    const PERMISSION_STOCK_ORDERS_EDIT = 'stock-orders-edit';
    const PERMISSION_STOCK_ORDERS_DELETE = 'stock-orders-delete';
    const PERMISSION_STOCK_ORDERS_VIEW = 'stock-orders-view';
    const PERMISSION_STOCK_ORDERS_RECEIVE = 'stock-orders-receive';
    const PERMISSION_STOCK_ORDERS_DISPLAYED = 'stock-orders-displayed';
    const PERMISSION_REPORTS = 'reports';

    public static $permission = [
        self::PERMISSION_ROLES => 'Roles',
        self::PERMISSION_USERS => 'Users',
        self::PERMISSION_SUPPLIERS => 'Suppliers',
        self::PERMISSION_BRANDS => 'Brands',
        self::PERMISSION_PRACTICES => 'Practices',
        self::PERMISSION_STOCK_ORDERS => 'Stock Orders',
        self::PERMISSION_STOCK_ORDERS_ADD => 'Stock Orders Add',
        self::PERMISSION_STOCK_ORDERS_EDIT => 'Stock Orders Edit',
        self::PERMISSION_STOCK_ORDERS_DELETE => 'Stock Orders Delete',
        self::PERMISSION_STOCK_ORDERS_VIEW => 'Stock Orders View',
        self::PERMISSION_STOCK_ORDERS_RECEIVE => 'Stock Orders Receive',
        self::PERMISSION_STOCK_ORDERS_DISPLAYED => 'Stock Orders Displayed',
        self::PERMISSION_REPORTS => 'Reports',
    ];
}
