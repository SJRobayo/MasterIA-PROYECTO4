<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aisle extends Model
{
    //

    public $fillable = ['id', 'aisle'];

    

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
