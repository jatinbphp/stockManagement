<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductsOptions extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['product_id', 'option_name', 'required'];

    public function product_option_values()
    {
        return $this->hasMany(ProductsOptionsValues::class, 'option_id')->orderBy('id', 'ASC');
    }
}
