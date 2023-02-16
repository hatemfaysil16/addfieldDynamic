<?php

namespace App\Http\Controllers;

use App\Models\User2;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    public function index(){
        $nameTable='users';
        $user1=DB::connection('mysql')->table($nameTable)->
        select('google_id','name','email','email_verified_at','password','phone','address','type','branch_id','avatar','remember_token')
        ->get()->toArray();
        foreach($user1 as $item){
            foreach($item as $key=>$value){
                $this->myDropColumnIfExists($nameTable,$key);
            }
        }
        $data=DB::connection('mysql')->table($nameTable)->
        select('google_id','name','email','email_verified_at','password','phone','address','type','branch_id','avatar','remember_token')
        ->get()->toArray();
        $userData=json_decode(json_encode($data), true);
         DB::connection('mysql2')->table($nameTable)->insert($userData);
        dd('success');
    }

public function myDropColumnIfExists($myTable, $column)
{
    if (!Schema::connection('mysql2')->hasColumn($myTable, $column)) //check the column
    {
        Schema::connection('mysql2')->table($myTable, function($table) use($column)
        {
            $table->engine = 'InnoDB';
            $table->string($column)->nullable();
        });
    }
}


}
