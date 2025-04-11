<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //
    public $fillable = ['department_id', 'department'];



    public function products()
    {
        return $this->hasMany(Product::class);
    }
}


