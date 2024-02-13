<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOrderStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = ['stock_order_id', 'status', 'notes_text', 'updated_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
