<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PageProduct;
use App\Models\Product;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProductController extends Controller
{
 
    public function __invoke(){
        $nameTable='page_product';
        $nameTable2='products';
        $products = Product::get()->pluck('id','name');
    $array=array();
        foreach($products as $key=>$value){
            preg_match_all('!\d+!', $key, $matches);
                foreach($matches as $item){
                    $weight=implode($item);
                }
                $pos = strpos($key, $weight, 1);
                $find_email = substr($key,0,$pos);
                array_push($array, [$value=>trim($find_email)]);
        }
$uniques = array();
foreach ($array as $value) {
    foreach($value as $key=>$value){
    // $uniques[$value] = $value;
    $uniques[] = $value;
    }
}
$productsId = array_unique( $uniques,SORT_REGULAR );
$products = Product::whereIn('id',array_keys($array))->get();
        foreach($products as $product){
            $category_ids = array();
            foreach($product->PageProduct as $item){
                array_push($category_ids, ['id'=>$item->id,'postion'=>0]);
            }
            array_push($category_ids, ['id'=>$item->id,'postion'=>0]);
            $variation = array();
            preg_match_all('!\d+!', $product->name, $matches);
            foreach($matches as $matche){
                $weight=implode($matche);
            }
        $ProductName = preg_replace('/\d+/u', '', $product->name);
        $NewNameProduct= str_replace('جم',"",$ProductName);
                $productsOld = Product::where('name', 'like' , '%'."{$NewNameProduct}".'%')->get();
                $a=0;
                $variation=array();
                foreach($productsOld as $itemOld){
                        preg_match_all('!\d+!', $itemOld->name, $matches);
                        $weight=[];
                        foreach($matches as $item){
                            $weight[]=implode($item);
                        }
                        // array_push($variation, ['type'=>'','weight'=>$weight,'price'=>$itemOld->price->price ??0,'discount'=>0,'sku'=>'13-6165','qty'=>$itemOld->quantity??0,'parent'=>'13-SCF-W20-001-BRG']);
                        $a++;
                        $variation[$a]['type']='';
                        $variation[$a]['price']=$itemOld->price->price ??0;
                        $variation[$a]['discount']=0;
                        $variation[$a]['sku']='13-6165';
                        $variation[$a]['qty']=$itemOld->quantity??0;
                        $variation[$a]['weight']=implode($weight);
                        $variation[$a]['parent']='13-SCF-W20-001-BRG';
                }
         DB::connection('mysql2')->table($nameTable2)->insert([
            'added_by'=>'admin',
            'user_id'=>'1',
            'name'=>\trim($NewNameProduct)??'',
            'slug'=>!empty($NewNameProduct)?Str::slug($NewNameProduct):'',
            'category_ids'=>!empty($category_ids)?json_encode($category_ids):'',
            'brand_id'=>'1',
            'unit'=>'pc',
            'min_qty'=>'1',
            'refundable'=>'1',
            'images'=>!empty($product->image)?json_encode($product->image):'',
            'featured'=>'',
            'colors'=>'',
            'variant_product'=>0,
            'attributes'=>'',
            'choice_options'=>'',
            'variation'=>json_encode($variation),
            'published'=>0,
            'unit_price'=>0,
            'purchase_price'=>0,
            'discount'=>'',
            'discount_type'=>'',
            'current_stock'=>0,
            'details'=>'',
            'status'=>0,
            'code'=>'',
         ]);
        }
        
        dd('success');
    }

}

