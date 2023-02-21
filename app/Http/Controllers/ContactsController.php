<?php

namespace App\Http\Controllers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ContactsController extends Controller
{
    public function __invoke(){
        $nameTable='contacts';
        $contactUs=DB::connection('mysql')->table($nameTable)->
        select('first_name','last_name','email','phone','address','message','created_at','updated_at')
        ->get()->toArray();
        // foreach($contactUs as $item){
        //     foreach($item as $key=>$value){
        //         $this->myDropColumnIfExists($nameTable,$key);
        //     }
        // }
        $contacts=DB::connection('mysql')->table($nameTable)->
        select('first_name','last_name','email','phone','address','message','created_at','updated_at')
        ->get()->toArray();
        foreach($contacts as $contact){
         DB::connection('mysql2')->table($nameTable)->insert([
            'name'=>$contact->first_name.' '.$contact->last_name,
            'email'=>$contact->email,
            'mobile_number'=>$contact->phone,
            'address'=>$contact->address,
            'message'=>$contact->message,
            'created_at'=>$contact->created_at,
            'updated_at'=>$contact->updated_at,
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

