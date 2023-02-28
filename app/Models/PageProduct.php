<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PageProduct extends Model
{
    use HasFactory;
protected $connection="mysql";
protected $table="page_product";
protected $guarded = ['id','created_at','updated_at'];



public function product(): BelongsTo
{
    return $this->belongsTo(Product::class, 'product_id');
}
public function page(): BelongsTo
{
    return $this->belongsTo(Page::class, 'page_id');
}

    // public function parentUp():BelongsTo
    // {
    //     return $this->belongsTo(self::class, 'parent_id');
    // }
    // public function children():HasMany
    // {
    //     return $this->hasMany(self::class, 'parent_id');
    // }
}
