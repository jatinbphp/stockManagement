<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class UserAddresses extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'title', 'first_name', 'last_name', 'company', 'mobile_phone', 'address_line1', 'address_line2', 'pincode', 'city', 'state', 'country', 'additional_information'];
}