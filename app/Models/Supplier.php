<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $appends = ['full_name'];

    protected $fillable = ['name', 'email', 'telephone', 'account_number', 'status'];

    protected $dates = ['deleted_at'];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    public static $status = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In Active',
    ];

    public function brand(){
        return $this->hasMany(Brand::class)->orderBy('name');
    }

    public function stockOrder(){
        return $this->hasMany(StockOrder::class);
    }

    public function getFullNameAttribute()
    {
        return $this->name . ' (' . $this->email . ')';
    }
}
