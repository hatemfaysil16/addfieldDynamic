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
    public function __invoke(){
        $nameTable='users';
        $user1=DB::connection('mysql')->table($nameTable)->
        select('google_id','name','email','email_verified_at','password','phone','address','type','branch_id','avatar','remember_token')
        ->get()->toArray();
        // foreach($user1 as $item){
        //     foreach($item as $key=>$value){
        //         $this->myDropColumnIfExists($nameTable,$key);
        //     }
        // }
        $users=DB::connection('mysql')->table($nameTable)->
        select('google_id','name','email','email_verified_at','password','phone','address','type','branch_id','avatar','remember_token','created_at','updated_at')
        ->get()->toArray();
        // $userData=json_decode(json_encode($users), true);
        foreach($users as $user){
         DB::connection('mysql2')->table($nameTable)->insert([
            'google_id'=>$user->google_id,
            'name'=>$user->name,
            'email'=>$user->email,
            'email_verified_at'=>$user->email_verified_at,
            'password'=>$user->password,
            'phone'=>$user->phone,
            'street_address'=>$user->address,
            'type'=>$user->type,
            'branch_id'=>$user->branch_id,
            'avatar'=>$user->avatar,
            'remember_token'=>$user->remember_token,
            'created_at'=>$user->created_at,
            'updated_at'=>$user->updated_at,
         ]);
        }
        
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
