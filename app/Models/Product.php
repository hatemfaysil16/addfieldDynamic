<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
