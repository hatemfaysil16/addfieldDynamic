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
    protected $fillable = [
        'name','slug','description','selector','nav','gallery','sub_of','deleted','dropdown','image'
    ];

        public function parentUp()
    {
        return $this->belongsTo(self::class, 'sub_of');
    }
    public function children()
    {
        return $this->hasMany(Page::class, 'sub_of','id');
    }
}
