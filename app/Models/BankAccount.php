<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
  /**
     * The attributes that are mass assignable.
     */
    protected $table = 'bank_accounts'; // Specify the table name

    protected $fillable = [
        'seller_id',
        'bank_acc_name',
        'bank_acc_number',
        'bank_type',
    ];

    /**
     * Define the relationship with the Seller model.
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
