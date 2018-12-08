<?php

namespace App\Http\Controllers\Product;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function product($product)
    {
         $products = Product::where('prod_type', $product)->get();
         //$model = User::where('votes', '>', 100)->firstOrFail();
         //$products = Product::all();

         return response()->json(['products' => $products]);
    }

}
