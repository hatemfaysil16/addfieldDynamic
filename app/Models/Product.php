<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
protected $connection="mysql";
protected $table="products";
protected $guarded = [];

public function PageProduct()
{
    return $this->hasMany(PageProduct::class);
}
public function Price()
{
    return $this->hasOne(Price::class);
}
}
