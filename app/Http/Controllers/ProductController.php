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
        $nameTable2='products';
        $products = Product::get();
        foreach($products as $product){
        $code = uniqid(mt_rand(10, 99));
            //image start
            $image=[];
            $ExplodImage=explode('/',$product->image);
            $EndExplodeImage = end($ExplodImage);
            array_push($image, $EndExplodeImage);
            //image end
            //category start
            $category_ids = [];
            $PageProduct = PageProduct::where('product_id',$product->id)->get();
            foreach($PageProduct as $item){
                if(isset($item->page->children)){
                    foreach($item->page->children??'[]' as $newItemId){
                        array_push($category_ids, ['id'=>\json_encode($newItemId->id),'position'=>0]);
                    }
                }
            }
            //category end
            //variation start
            $variation=[];
               preg_match_all('!\d+!', $product->name, $matches);
                foreach($matches as $ItemWeight){
                    $weight=implode($ItemWeight);
                }
            array_push($variation, ['type'=>$weight,'weight'=>$weight,'price'=>$product->price->price ??0,'discount'=>0,'sku'=>uniqid(mt_rand(10, 99)),'qty'=>$product->quantity??0,'parent'=>$code]);
            //variation end
            //weight start
            $FieldWeightOption=[];
            $weightOption = ['name'=>'choice_1','title'=>'Weight','options'=>[$weight]];
            array_push($FieldWeightOption, $weightOption);
            // dd($FieldWeightOption);
            //weight end
            //price start
            $price = array_column($variation , 'price');
            $minPrice =!empty($price)?min($price):'';
            $maxPrice =!empty($price)?min($price):'';
            $unit_price = ($minPrice>0)?$minPrice:$maxPrice;
            $purchase_price = ($minPrice>0)?$minPrice:$maxPrice;
            //price end
            //Qty start
            $QtyColum = array_column($variation, 'qty');
            $sumQty=implode($QtyColum);
            //Qty end
            //Details start
            $details =  $product->taste.$product->benefits.$product->how_to_use.$product->description;
            //Details end
             DB::connection('mysql2')->table($nameTable2)->insert([
            'id'=>$product->id,
            'added_by'=>'admin',
            'user_id'=>'1',
            'name'=>$product->name,
            'slug'=>$product->slug,
            'category_ids'=>!empty($category_ids)?json_encode($category_ids):'',
            'brand_id'=>'1',
            'unit'=>'pc',
            'min_qty'=>'1',
            'refundable'=>'1',
            'images'=>!empty($image)?json_encode($image):'',
            'thumbnail'=>isset($image[0])?$image[0]:'',
            'featured'=>'',
            'video_provider'=>'youtube',
            'variant_product'=>0,
            'attributes'=>null,
            'choice_options'=>!empty($weight[0])?\json_encode($FieldWeightOption):'[]',
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

