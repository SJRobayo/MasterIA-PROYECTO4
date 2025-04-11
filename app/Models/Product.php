<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //

    public $fillable = ['id', 'product_name', 'department_id', 'aisle_id'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function aisle()
    {
        return $this->belongsTo(Aisle::class, 'aisle_id');
    }


}
