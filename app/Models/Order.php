<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'order_id','address_id', 'total_amount','status','delivey_method','notes'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    const STATUS_TYPE_PENDING  = 'pending';
    const STATUS_TYPE_REJECT   = 'reject';
    const STATUS_TYPE_COMPLETE = 'complete';
    const STATUS_TYPE_CANCEL   = 'cancel';
    public static $allStatus = [
        self::STATUS_TYPE_PENDING,
        self::STATUS_TYPE_REJECT,
        self::STATUS_TYPE_COMPLETE,
        self::STATUS_TYPE_CANCEL,
    ];
    
    const DELIVERY_METHOD_FEDEX = 'FEDEX';
    public static $allDeliveryMethod = [
        self::DELIVERY_METHOD_FEDEX => 'FEDEX',
    ];
}
