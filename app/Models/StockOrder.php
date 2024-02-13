<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockOrder extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['brand_id', 'supplier_id', 'practice_id', 'instructions', 'order_copy', 'status'];

    const STATUS_OPEN     = 'open';
    const STATUS_IN_COMPLETE   = 'incomplete';
    const STATUS_COMPLETED   = 'completed';

    public static $status = [
        self::STATUS_OPEN => 'Open',
        self::STATUS_IN_COMPLETE => 'Incomplete',
        self::STATUS_COMPLETED => 'Completed',
    ];

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function practice(){
        return $this->belongsTo(Practice::class);
    }
}
