<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'price',
        'status',
        'transaction_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
