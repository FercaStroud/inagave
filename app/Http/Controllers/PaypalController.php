<?php

namespace App\Http\Controllers;

use App\Mail\CreatePreferenceMail;
use App\Mail\DepositToWalletMail;
use App\Mail\FeedbackMail;
use App\Mail\ProductSoldMail;
use App\Payment;
use App\Percentage;
use App\Product;
use App\User;
use App\Wallet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Classes\PayPalClient;

class PaypalController extends Controller
{
    public function index()
    {

    }

    public function insertOnWallet($owner, $product, $newProduct, $payment)
    {
        $percentages = Percentage::all();
        $transactions = [];

        $lastID = 0;
        //parent
        foreach ($percentages as $key => $percentage) {
            if ($percentage->name === 'USER') {
                $wallet = new Wallet();
                $wallet->user_id = $owner->id;
                $wallet->status = 'VENTA COMPLETADA';
                $wallet->amount = (float)$payment->total * ((float)$percentage->value / 100);
                $wallet->bank = $percentage->name;
                $wallet->account = $percentage->name;
                $wallet->type = 'DEPOSIT';
                $wallet->save();
                $lastID = $wallet->id;
                array_push($transactions, $wallet);
            }
        }
        //children
        foreach ($percentages as $key => $percentage) {
            if ($percentage->name !== 'USER') {
                $wallet = new Wallet();
                $wallet->user_id = $owner->id;
                $wallet->parent_id = $lastID;
                $wallet->status = 'VENTA COMPLETADA';
                $wallet->amount = (float)$payment->total * ((float)$percentage->value / 100);
                $wallet->bank = $percentage->name;
                $wallet->account = $percentage->name;
                $wallet->type = 'DEPOSIT';
                $wallet->save();
                array_push($transactions, $wallet);
            }
        }


        Mail::send(new DepositToWalletMail($owner, $transactions));
        Mail::send(new ProductSoldMail($owner, $newProduct));
    }

    public function preference(Request $request)
    {
        $selectedPrice = $request->get('selectedPrice');

        $request->validate([
            'checkoutQty' => 'required',
        ]);

        $product = Product::find($request->get('id'));

        if ((integer)$product->quantity < (integer)$request->get('checkoutQty')) {

            return response()->json($product, 500);
        } else {

            $paypalClient = new PayPalClient();

            if ($request->has('app_user')) {
                $user = User::find($request->get('app_user'));
            } else {
                $user = User::find(auth()->user()->id);
            }

            $owner = User::find($request->get('user_id'));

            if ($owner->isAdmin()) {
                if($selectedPrice === "inagave") {
                    $price = (float)$product->price;
                } else{
                    $price = (float)$product->maintenance_price;
                }
            } else {
                $price = (float)$request->get('price');
            }

            $arrayBody = [
                'intent' => 'CAPTURE',
                'application_context' => [
                    'brand_name' => "INAGAVE",
                    'locale' => 'es-MX',
                    'landing_page' => 'NO_PREFERENCE',
                    'shipping_preference' => 'NO_SHIPPING',
                    'user_action' => 'PAY_NOW',
                    "cancel_url" => env('APP_URL') . "/api/paypal/checkout/feedback" .
                        "?type=cancel",
                    "return_url" => env('APP_URL') . "/api/paypal/checkout/feedback" .
                        "?type=return"
                ],
                'purchase_units' => [
                    [
                        'description' => $product->estate . ' / ' . $request->get('checkoutQty') . ' Item(s)',
                        'soft_descriptor' => 'INAGAVE',
                        'amount' => [
                            'currency_code' => 'MXN',
                            'value' => number_format((float)$request->get('checkoutQty') * $price,2, '.', ''),
                        ]
                    ]
                ],
            ];

            $result = $paypalClient->createOrder($arrayBody);
            return response()->json($result);

            $payment = new Payment($product->toArray());
            $payment->user_id = $user->id;
            $payment->product_id = $product->id;
            $payment->quantity = (integer)$request->get('checkoutQty');
            $payment->total = $price * (float)$request->get('checkoutQty');
            $payment->preference_id = $result->result->id;
            $payment->type = 'PayPal';
            $payment->preference_status = 1;
            $payment->feedback_status = 0;
            $payment->selected_payment = $selectedPrice;
            $payment->save();

            Mail::send(new CreatePreferenceMail($payment, $user));
            return response()->json($result);
        }
    }

    public function feedback(Request $request)
    {
        if($request->get('type') === "cancel"){
            return response(['ERROR' => 'PAGO CANCELADO']);
        }

        $payment = Payment::where('preference_id', '=', $request->get('token'))->get();

        if ($payment[0]->feedback_status === 1) {
            return response(['ERROR' => 'PREFERENCE_ID PROCESADO CON ANTERIORIDAD']);
        }
        $paypalClient = new PayPalClient();
        $result = $paypalClient->getOrder($request->get("token"));

        $payment = Payment::find($payment[0]->id);
        $payment->collection_id = $result->result->id;
        $payment->collection_status = $result->result->status;
        $payment->payment_id = $result->result->id;
        $payment->status = $result->result->status;
        $payment->external_reference = 'PayPal';
        $payment->payment_type = 'PayPal';
        $payment->merchant_order_id = $result->result->payer->payer_id;
        $payment->preference_id = $result->result->payer->payer_id;
        $payment->site_id = $result->result->payer->email_address;
        $payment->processing_mode = 'PayPal';
        $payment->merchant_account_id = $result->result->payer->payer_id;

        $payment->feedback_status = 1;
        $payment->save();

        if ($result->result->status === 'APPROVED') {
            $product = Product::find($payment->product_id);
            $product->quantity = (integer)$product->quantity - (integer)$payment->quantity;
            $product->save();

            $newProduct = $product->replicate();
            $newProduct->push();
            $newProduct->quantity = (integer)$payment->quantity;
            $newProduct->user_id = $payment->user_id;
            $newProduct->available = 0;
            if($payment->selected_payment === "inagave"){
                $newProduct->maintenance_type = 0;
            } else{
                $newProduct->maintenance_type = 1;
            }
            $newProduct->save();
            Mail::send(new FeedbackMail($payment, $newProduct));
            $owner = User::find($product->user_id);

            if (!$owner->isAdmin() && $newProduct->id !== $owner->id) {
                $this->insertOnWallet($owner, $product, $newProduct, $payment);
            }
            return response()->view('responses.feedback_success',
                [
                    'payment' => $payment
                ]
            );
        } else {
            return response(['ERROR' => 'PAGO NO APROBADO']);
        }
    }
}
