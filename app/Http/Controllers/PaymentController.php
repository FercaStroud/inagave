<?php

namespace App\Http\Controllers;

use App\Mail\FeedbackMail;
use App\Payment;
use App\Product;
use Exception;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use MercadoPago\Item;
use MercadoPago\Payer;
use MercadoPago\Preference;
use MercadoPago\SDK;
use App\Mail\CreatePreferenceMail;

class PaymentController extends Controller
{
    public function createPreferences(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'checkoutQty' => 'required',
        ]);

        $product = Product::find($request->get('id'));
        if ((integer)$product->quantity < (integer)$request->get('checkoutQty')) {

            return response()->json($product, 500);
        } else {
            SDK::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));
            $preference = new Preference();
            $payer = new Payer();

            $payer->name = auth()->user()->name;
            $payer->surname = auth()->user()->lastname;
            $payer->email = auth()->user()->email;
            $preference->payer = $payer;

            $item = new Item();
            $item->title = $product->estate . ' / ' . $request->get('checkoutQty') . ' Item(s)';
            $item->quantity = (integer)$request->get('checkoutQty');
            $item->unit_price = (float)$product->price;
            $item->currency_id = "MXN";
            $preference->items = [$item];
            $preference->back_urls = [
                "failure" => env('APP_URL') . "/api/checkout/feedback",
                "success" => env('APP_URL') . "/api/checkout/feedback",
                "pending" => env('APP_URL') . "/api/checkout/feedback"
            ];
            $preference->auto_return = "approved";
            $preference->payment_methods = [
                "excluded_payment_types" => [
                    ["id" => "ticket"], ["id" => "atm"], ["id" => "digital_currency"]
                ]
            ];
            $preference->save();

            $payment = new Payment($product->toArray());
            $payment->user_id = auth()->user()->id;
            $payment->product_id = $product->id;
            $payment->quantity = (integer)$request->get('checkoutQty');
            $payment->total = (float)$product->price * (float)$request->get('checkoutQty');
            $payment->preference_id = $preference->id;
            $payment->preference_status = 1;
            $payment->feedback_status = 0;
            $payment->save();

            Mail::send(new CreatePreferenceMail($payment));

            return response()->json(['id' => $preference->id], 200);
        }
    }

    public function feedback(Request $request): \Illuminate\Http\Response
    {
        $payment = Payment::where('preference_id', '=', $request->get('preference_id'))->get();

        if ($payment[0]->feedback_status === 1) {
            return response()->view('responses.feedback_error',
                [
                    'ERROR' => 'PREFERENCE_ID PROCESADO CON ANTERIORIDAD'
                ]
            );
        }

        $payment = Payment::find($payment[0]->id);
        $payment->collection_id = $request->get('collection_id');
        $payment->collection_status = $request->get('collection_status');
        $payment->payment_id = $request->get('payment_id');
        $payment->status = $request->get('status');
        $payment->external_reference = $request->get('external_reference');
        $payment->payment_type = $request->get('payment_type');
        $payment->merchant_order_id = $request->get('merchant_order_id');
        $payment->preference_id = $request->get('preference_id');
        $payment->site_id = $request->get('site_id');
        $payment->processing_mode = $request->get('processing_mode');
        $payment->merchant_account_id = $request->get('merchant_account_id');

        $payment->feedback_status = 1;
        $payment->save();

        if ($request->get('status') === 'approved') {
            $product = Product::find($payment->product_id);
            $product->quantity = (integer)$product->quantity - (integer)$payment->quantity;
            $product->save();

            $newProduct = $product->replicate();
            $newProduct->push();
            $newProduct->quantity = (integer)$payment->quantity;
            $newProduct->user_id = $payment->user_id;
            $newProduct->available = 0;
            $newProduct->save();
            Mail::send(new FeedbackMail($payment, $newProduct));
        }
        return response()->view('responses.feedback_success',
            [
                'payment' => $payment
            ]
        );

    }
}
