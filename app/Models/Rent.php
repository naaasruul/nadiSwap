<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    //
    protected $fillable = [
        'address',
        'house_type',
        'rent',
        'deposit',
        'facilities',
        'preferred_gender',
        'other_preferences',
        'images',
        'other_payments',
        'user_id',
    ];
}
