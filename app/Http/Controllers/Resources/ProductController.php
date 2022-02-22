<?php

namespace App\Http\Controllers\Resources;

use App\Maintenance;
use App\Product;
use Carbon\Carbon;
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
        $products = Product::with('images')->where([
            ['available', '=', 1],
            ['quantity', '>', 0]
        ])->with('user')->get();

        foreach ($products as $key => $product) {
            $products[$key]['checkoutQty'] = 1;
        }
        return $products;
    }

    public function addProductToUser(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required',
        ]);

        $product = Product::find($request->get('product_id'));
        if ((integer)$product->quantity < (integer)$request->get('quantity')) {

            return response()->json($product, 500);
        } else {
            $product->quantity = (integer)$product->quantity - (integer)$request->get('quantity');
            $product->save();

            $newProduct = $product->replicate();
            $newProduct->push();
            $newProduct->quantity = (integer)$request->get('quantity');
            $newProduct->available = 0;
            $newProduct->user_id = (integer)$request->get('id');
            $newProduct->maintenance_type = (bool)(int)$request->get('maintenance_type', 0);

            $newProduct->save();

            return response()->json($newProduct);
        }

    }

    public function getUserProducts(Request $request)
    {
        if ($request->has('user_id')) {
            $userId = $request->get('user_id');
        } else {
            $userId = auth()->user()->id;
        }

        $products = Product::with('maintenances')
            ->where([
                ['quantity', '>', 0],
                ['user_id', '=', $userId]
            ])
            ->with('user')->get();

        foreach ($products as $key => $product) {
            $maintenance = Maintenance::where([
                ['status', '=', 'approved'],
                ['product_id', '=', $product->id]
            ])->latest('created_at')->first();

            if ($maintenance !== null) {
                $products[$key]['isMaintenancePaid'] = Carbon::now()->between(Carbon::parse($maintenance->start_date), Carbon::parse($maintenance->end_date));
            } else {
                $products[$key]['isMaintenancePaid'] = false;
            }
            $products[$key]['cloneQty'] = 1;
        }
        return $products;
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

    public function cloneProduct(Request $request): JsonResponse
    {
        $request->validate([
            'cloneQty' => 'required',
        ]);

        $product = Product::find($request->get('id'));
        if ((integer)$product->quantity < (integer)$request->get('cloneQty')) {

            return response()->json($product, 500);
        } else {
            $product->quantity = (integer)$product->quantity - (integer)$request->get('cloneQty');
            $product->save();

            $newProduct = $product->replicate();
            $newProduct->push();
            $newProduct->quantity = (integer)$request->get('cloneQty');
            $newProduct->available = 1;
            $newProduct->save();

            return response()->json($newProduct, 201);
        }

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
