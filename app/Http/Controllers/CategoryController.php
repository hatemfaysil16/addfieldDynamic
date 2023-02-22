<?php

namespace App\Http\Controllers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __invoke(){
        $nameTable='pages';
        $nameTable2='categories';
        $contactUs=DB::connection('mysql')->table($nameTable)->
        select('name','slug','description','selector','nav','gallery','sub_of','deleted','dropdown','image','banner','icon','order','created_at','updated_at')
        ->get()->toArray();
        // foreach($contactUs as $item){
        //     foreach($item as $key=>$value){
        //         $this->myDropColumnIfExists($nameTable2,$key);
        //     }
        // }
        $contacts=DB::connection('mysql')->table($nameTable)->
        select('name','slug','description','selector','nav','gallery','sub_of','deleted','dropdown','image','banner','icon','order','created_at','updated_at')
        ->get()->toArray();
        foreach($contacts as $contact){
// name	
// slug	
// icon	
// parent_id	
// position	
// created_at	
// updated_at	
// home_status	
// priority
         DB::connection('mysql2')->table($nameTable2)->insert([
            'name'=>$contact->name,
            'slug'=>Str::slug($contact->name),
            'icon'=>$contact->icon,
            'parent_id'=>$contact->sub_of,
            'description'=>$contact->description,
            'selector'=>$contact->selector,
            'nav'=>$contact->nav,
            'gallery'=>$contact->gallery,
            'deleted'=>$contact->deleted,
            'dropdown'=>$contact->dropdown,
            'image'=>$contact->image,
            'banner'=>$contact->banner,
            'order'=>$contact->order,
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
            $table->longText($column)->nullable();
        });
    }
}


}

