<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCategoryPreference extends Model
{
    protected $fillable = ['user_id', 'category', 'weight'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
