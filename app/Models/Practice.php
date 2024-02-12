<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Practice extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'name', 'address', 'email', 'telephone', 'manager_name', 'status',
    ];

    protected $dates = ['deleted_at'];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    public static $status = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In Active',
    ];
}
