<?php

namespace App\Http\Controllers\Resources;

use App\Price;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Http\JsonResponse;

class PricesController extends Controller
{
    public function index()
    {
       return Price::all();
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'price' => 'required',
            'weight' => 'required',
            'default' => 'required',
        ]);

        $price = new Price($request->all());
        $price->save();
        return response()->json($price, 201);
    }

    public function update(Request $request, Price $price): JsonResponse
    {
        $request->validate([
            'price' => 'required',
            'weight' => 'required',
            'default' => 'required',
        ]);

        tap($price)->update($request->all());

        $price->save();
        return response()->json($price, 201);
    }

    public function destroy(Price $price): JsonResponse
    {
        $price->delete();

        return response()->json(null, 204);
    }
}
