<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockOrderReceiveDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['stock_order_receive_id', 'document_name', 'added_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}