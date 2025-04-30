<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    //
    protected $fillable = ['place', 'shipping_fee', 'seller_id']; // Allow mass assignment for these fields

}
