<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    //
    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products() 
    {
        return $this->belongsToMany(Product::class, 'basket_products', 'basket_id', 'product_id');
    }
}
