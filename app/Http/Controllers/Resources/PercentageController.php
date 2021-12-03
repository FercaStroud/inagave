<?php

namespace App\Http\Controllers\Resources;

use App\Percentage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Http\JsonResponse;

class PercentageController extends Controller
{
    public function index()
    {
       return Percentage::all();
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'value' => 'required',
        ]);

        $percentage = new Percentage($request->all());
        $percentage->save();
        return response()->json($percentage, 201);
    }

    public function update(Request $request, Percentage $percentage): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'value' => 'required',
        ]);

        tap($percentage)->update($request->all());

        $percentage->save();
        return response()->json($percentage, 201);
    }

    public function destroy(Percentage $percentage): JsonResponse
    {
        $percentage->delete();

        return response()->json(null, 204);
    }
}
