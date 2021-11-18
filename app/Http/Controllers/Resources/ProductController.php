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
       return Product::all();
    }

    public function getStoreProducts()
    {
        $products = Product::with('images')->get();
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
        $product->save();

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
