<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    use HasFactory;
protected $connection="mysql";
protected $table="pages";
protected $guarded = [];
    public function parentUp():BelongsTo
    {
        return $this->belongsTo(self::class, 'sub_of');
    }
    public function children():HasMany
    {
        return $this->hasMany(self::class, 'sub_of');
    }
}
