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


    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'price' => 'required',
            'quantity' => 'required',
        ]);

        $product = new Product($request->all());
        $product->save();

        return response()->json($product);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
