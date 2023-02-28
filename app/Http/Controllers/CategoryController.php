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

        $contacts=DB::connection('mysql2')->table($nameTable2)->get();

        $b = \json_decode(\json_encode($contacts),true);
        foreach($b as $itemss){
            $NewNameProduct= str_replace(' ','-',$itemss['name']);
           DB::connection('mysql2')->table($nameTable2)->where('id',$itemss['id'])->update(['slug'=>$NewNameProduct]);
        }
        // dd($contacts);
        dd('stop');
        // $contactUs=DB::connection('mysql')->table($nameTable)->
        // select('name','slug','description','selector','nav','gallery','sub_of','deleted','dropdown','image','banner','icon','order','created_at','updated_at')
        // ->get()->toArray();
        // foreach($contactUs as $item){
        //     foreach($item as $key=>$value){
        //         $this->myDropColumnIfExists($nameTable2,$key);
        //     }
        // }
        $contacts=DB::connection('mysql')->table($nameTable)->
        select('id','name','slug','description','selector','nav','gallery','sub_of','deleted','dropdown','image','banner','icon','order','created_at','updated_at')
        ->whereNotIn('id', [127,128,160,161,162,163,164,165,166,167,168,169,170,235,236,237,238,186,187,188,189,190,192,193,194,195,200])
        // new add [128,161,162,163,164,165,166,167,168,169,170,235]
        ->get()->toArray();
        foreach($contacts as $contact){
        $image=[];
        $banner=[];
        $ExplodImage=explode('/',$contact->image);
        $EndExplodeImage = end($ExplodImage);
        array_push($image, $EndExplodeImage);
        $ExplodeBanner=explode('/',$contact->banner);
        $EndExplodeBanner = end($ExplodeBanner);
        array_push($banner, $EndExplodeBanner);

         DB::connection('mysql2')->table($nameTable2)->insert([
            'id'=>$contact->id,
            'name'=>$contact->name,
            'slug'=>Str::slug($contact->name),
            'icon'=>$image[0] ??'',
            'parent_id'=>$contact->sub_of,
            'position'=>'0',
            'home_status'=>'1',
            'description'=>$contact->description,
            'selector'=>$contact->selector,
            'nav'=>$contact->nav,
            'gallery'=>$contact->gallery,
            'deleted'=>$contact->deleted,
            'dropdown'=>$contact->dropdown,
            'image'=>$image[0]??'',
            'banner'=>$banner[0]??'',
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

