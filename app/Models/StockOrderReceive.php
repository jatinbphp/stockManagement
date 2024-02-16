<?php

namespace App\Models;
use App\Models\StockOrderReceiveDocument;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockOrderReceive extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['stock_order_id', 'grv_number', 'inv_number', 'notes', 'added_by'];

    public function stock_order_receive_documents()
    {
        return $this->hasMany(StockOrderReceiveDocument::class, 'stock_order_receive_id')->orderBy('id', 'ASC');
    }
}