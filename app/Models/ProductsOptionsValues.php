<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductsOptionsValues extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['product_id', 'option_id', 'option_value', 'option_price'];
}
