<?php

namespace App\Http\Controllers\Resources;

use App\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Http\JsonResponse;

class ProductImageController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required',
        ]);

        $images = ProductImage::where('product_id', '=', $request->get('product_id'))->get();

        return response()->json($images, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required',
            'name' => 'required',
            'imgFile' => 'required',
        ]);

        $productImage = new ProductImage($request->all());

        $fileName = Str::random(68).'.'.$request->file('imgFile')->getClientOriginalExtension();
        $destinationPath = "products/";

        $request->file('imgFile')->move($destinationPath, $fileName);
        $productImage->src = $fileName;

        $productImage->save();

        return response()->json($productImage, 201);
    }

    public function destroy(ProductImage $productImage): JsonResponse
    {
        $productImage->delete();

        return response()->json(null, 204);
    }
}
