<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'image', 'status', 'supplier_id'];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    public static $status = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In Active',
    ];

    public function supplier(){
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function stockOrder(){
        return $this->hasMany(StockOrder::class);
    }
}
