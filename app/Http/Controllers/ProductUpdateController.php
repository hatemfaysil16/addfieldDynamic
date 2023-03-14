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

class ProductUpdateController extends Controller
{
    public function __invoke(){
        $nameTable2='products';
        $products = DB::connection('mysql2')->table($nameTable2)->get();
        foreach($products as $product){
            //get price database old
            $productsOld = Product::find($product->id);
            $productsOldPrice = $productsOld->price->price??'';
            //get price database old

        // variation
        $variation=[];
        foreach(\json_decode($product->variation) as $ItemVariation){
            // \Log::info('id/'.  $product->id .'<br>'.$ItemVariation->weight ?? '');
            array_push($variation, ['type'=>$ItemVariation->type,'weight'=>$ItemVariation->weight ?? '','price'=>!empty($productsOldPrice)?$productsOldPrice:$ItemVariation->price,
            'discount'=>$ItemVariation->discount ?? 0,'sku'=>$ItemVariation->sku,'qty'=>$ItemVariation->qty,'parent'=>$ItemVariation->parent ?? 0]);
        }
        // variation
            //new update price database
         DB::connection('mysql2')->table($nameTable2)->where('id',$product->id)->update([
            'unit_price'=>isset($productsOldPrice)?(int)$productsOldPrice:0,
            'purchase_price'=>(int)$productsOldPrice,
            'variation'=>\json_encode($variation),
        ]);
        }

        dd('success');
    }

}

