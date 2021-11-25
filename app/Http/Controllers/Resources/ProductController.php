<?php

namespace App\Http\Controllers\Resources;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index()
    {
       return Product::with('user')->get();
    }

    public function getStoreProducts()
    {
        $products = Product::with('images')->where('available', '=', 1)->get();
        foreach ($products as $key=>$product){
            $products[$key]['checkoutQty'] = 1;
        }
       return  $products;
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'price' => 'required',
            'quantity' => 'required',
        ]);

        $product = new Product($request->all());
        $product->user_id = auth()->user()->id;
        //$product->available = (bool)(int)$request->get('available', 1);
        $product->save();
        $product['user'] = auth()->user();
        return response()->json($product, 201);
    }

    public function update(Request $request, Product $product): JsonResponse
    {
        $request->validate([
            'price' => 'required',
            'quantity' => 'required',
        ]);

        tap($product)->update($request->all());

        $product->save();
        return response()->json($product, 201);
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json(null, 204);
    }
}
