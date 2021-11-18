<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use MercadoPago\Item;
use MercadoPago\Payer;
use MercadoPago\Preference;
use MercadoPago\SDK;

class CheckoutController extends Controller
{
    public function createPreferences(Request $request)
    {
        $request->validate([
            'checkoutQty' => 'required',
        ]);

        $product = Product::find($request->get('id'));
        if((Integer)$product->quantity < (Integer)$request->get('checkoutQty')) {

            return response()->json($product, 500);
        } else {
            SDK::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));
            $preference = new Preference();

            $item = new Item();
            $item->title = $product->estate.' / '.$request->get('checkoutQty').' Item(s)';
            $item->quantity = (Integer)$request->get('checkoutQty');
            $item->unit_price = (Float)$product->price;
            $item->currency_id = "MXN";

            $preference->back_urls = [
                "success" => env('APP_URL')."/feedback",
                "failure" => env('APP_URL')."/feedback",
                "pending" => env('APP_URL')."/feedback"
            ];
            $preference->auto_return = "approved";

            $preference->items = [$item];
            $preference->save();

            return response()->json(['id' => $preference->id], 200);
        }
    }
}
