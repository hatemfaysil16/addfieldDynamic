<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User2 extends Model
{
    use HasFactory;
    protected $connection="mysql2";
    protected $table="users";
protected $guarded = ['id','created_at','updated_at'];

    protected $hidden = [
        'id','created_at','updated_at','email_verified_at'
    ];
    
}
