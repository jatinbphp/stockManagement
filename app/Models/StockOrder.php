<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockOrder extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['brand_id', 'supplier_id', 'practice_id', 'instructions', 'order_copy', 'status', 'received_at'];

    const STATUS_IN_PROGRESS = 'inprogress';
    const STATUS_NEW_ONE = 'newone';
    const STATUS_OPEN = 'open';
    const STATUS_IN_COMPLETE = 'incomplete';
    const STATUS_COMPLETED = 'completed';

    public static $status = [
        self::STATUS_NEW_ONE => 'Displayed',
        self::STATUS_OPEN => 'Dispatched',
        self::STATUS_IN_COMPLETE => 'Order Received Incomplete',
        self::STATUS_COMPLETED => 'Order Received Complete',
    ];

    public function brand(){
        return $this->belongsTo(Brand::class, 'brand_id')->select('id', 'name');
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class, 'supplier_id')->select('id', 'name', 'email');
    }

    public function practice(){
        return $this->belongsTo(Practice::class, 'practice_id')->select('id', 'name', 'email');
    }

    public function stock_order_receive(){
        return $this->hasOne(StockOrderReceive::class)->latest();
    }

    public function stock_order_multi_receive(){
        return $this->hasMany(StockOrderReceive::class);
    }
}
