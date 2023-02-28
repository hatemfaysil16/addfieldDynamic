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
        $code = uniqid(mt_rand(10, 99));
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
    $uniques[] = $value;
    }
}
$productsId = array_unique( $uniques,SORT_REGULAR );
$products = Product::whereIn('id',array_keys($array))->get();
        foreach($products as $product){
            $category_ids = array();
            $PageProduct = PageProduct::where('product_id',$product->id)->get();
            foreach($PageProduct as $item){
                array_push($category_ids, ['id'=>\json_encode($item->page_id),'position'=>0]);
            }
            $variation = array();
            preg_match_all('!\d+!', $product->name, $matches);
            foreach($matches as $matche){
                $weight=implode($matche);
            }
        $ProductName = preg_replace('/\d+/u', '', $product->name);
        $NewNameProduct= str_replace('جم',"",$ProductName);
        $explodeProduct = explode(' ',$NewNameProduct);
            $arraysProduct=[];
            foreach($explodeProduct as $key=>$dataExplodeProduct){
                if(isset($dataExplodeProduct[$key])){
                    $arraysProduct[]=$dataExplodeProduct;
                }
            }
             $searchProduct=(join(" ",$arraysProduct));
            $productsOld = Product::where('name', 'like' , '%'."{$searchProduct}".'%')->get();
            $variation=array();
            $images=array();
            $colors=array();
            $FieldweightOption=array();
            foreach($productsOld as $itemOld){
                preg_match_all('!\d+!', $itemOld->name, $matches);
                foreach($matches as $item){
                    $weight=implode($item);
                }
                $explode=explode('/',$itemOld->image);
                $EndExplodeImage = end($explode);
                array_push($images, $EndExplodeImage);
                array_push($colors, [$weight]);
                array_push($variation, ['type'=>$weight,'weight'=>$weight,'price'=>$itemOld->price->price ??0,'discount'=>0,'sku'=>uniqid(mt_rand(10, 99)),'qty'=>$itemOld->quantity??0,'parent'=>$code]);
            }
            $details =  $product->taste.$product->benefits.$product->how_to_use.$product->description;
            $WeightColum = array_column($variation, 'weight');
            $arrayUniqueWeight = array_unique( $WeightColum,SORT_REGULAR );
            $weightOption = ['name'=>'choice_1','title'=>'Weight','options'=>$arrayUniqueWeight];
            array_push($FieldweightOption, $weightOption);
            $QtyColum = array_column($variation, 'qty');
            $sumQty = array_sum($QtyColum);
            $priceColum = array_column($variation , 'price');
            $minPrice =!empty($priceColum)?min($priceColum):'';
            $maxPrice =!empty($priceColum)?min($priceColum):'';
            $unit_price = ($minPrice>0)?$minPrice:$maxPrice;
            $purchase_price = ($minPrice>0)?$minPrice:$maxPrice;
             DB::connection('mysql2')->table($nameTable2)->insert([
            'id'=>$product->id,
            'added_by'=>'admin',
            'user_id'=>'1',
            'name'=>\trim($NewNameProduct)??'',
            'slug'=>!empty($NewNameProduct)?Str::slug($NewNameProduct):'',
            'category_ids'=>!empty($category_ids)?json_encode($category_ids):'',
            'brand_id'=>'1',
            'unit'=>'pc',
            'min_qty'=>'1',
            'refundable'=>'1',
            'images'=>!empty($images)?json_encode($images):'',
            'thumbnail'=>isset($images[0])?$images[0]:'',
            'featured'=>'',
            'video_provider'=>'youtube',
            'variant_product'=>0,
            'attributes'=>null,
            'choice_options'=>!empty($WeightColum[0])?\json_encode($FieldweightOption):'[]',
            'variation'=>json_encode($variation),
            'published'=>$sumQty>0?1:0,
            'unit_price'=>!empty($unit_price)?$unit_price:0,
            'purchase_price'=>!empty($purchase_price)?$purchase_price:0,
            'colors'=>'[]',
            'discount'=>0,
            'discount_type'=>'',
            'current_stock'=>$sumQty??'',
            'details'=>$details??'',
            'status'=>$sumQty>0?1:0,
            'code'=>$code,
         ]);
        }

        dd('success');
    }

}

