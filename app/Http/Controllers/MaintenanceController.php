<?php

namespace App\Http\Controllers;

use App\Classes\PayPalClient;
use App\Mail\CreateMaintenancePreferenceMail;
use App\Mail\MaintenanceFeedbackMail;
use App\Maintenance;
use App\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use MercadoPago\Item;
use MercadoPago\Payer;
use MercadoPago\Preference;
use MercadoPago\SDK;

class MaintenanceController extends Controller
{
    public function index()
    {
        return Maintenance::with('product')->get();
    }

    public function preference(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'quantity' => 'required',
            'price' => 'required',
        ]);

        $product = Product::find($request->get('id'));

        SDK::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));
        $preference = new Preference();
        $payer = new Payer();

        $payer->name = auth()->user()->name;
        $payer->surname = auth()->user()->lastname;
        $payer->email = auth()->user()->email;
        $preference->payer = $payer;

        $item = new Item();
        $item->title = 'PAGO DE MANTENIMIENTO - ' .$product->created_at;
        $item->quantity = (integer)$request->get('quantity');
        $item->unit_price = $request->get('price');
        $item->currency_id = "MXN";
        $preference->items = [$item];
        $preference->back_urls = [
            "failure" => env('APP_URL') . "/api/checkout/maintenance/feedback",
            "success" => env('APP_URL') . "/api/checkout/maintenance/feedback",
            "pending" => env('APP_URL') . "/api/checkout/maintenance/feedback"
        ];
        $preference->auto_return = "approved";
        $preference->payment_methods = [
            "excluded_payment_types" => [
                ["id" => "ticket"], ["id" => "atm"], ["id" => "digital_currency"]
            ]
        ];
        $preference->save();

        $maintenance = new Maintenance();
        $maintenance->product_id = $product->id;
        $maintenance->price = $request->get('price');
        $maintenance->quantity = $product->quantity;
        $maintenance->total = (float)$request->get('price') * (float)$product->quantity;

        $maintenance->preference_id = $preference->id;
        $maintenance->preference_status = 1;
        $maintenance->feedback_status = 0;
        $maintenance->start_date = now();
        $maintenance->end_date = now()->addYear();;
        $maintenance->save();

        Mail::send(new CreateMaintenancePreferenceMail($maintenance));

        return response()->json(['id' => $preference->id], 200);
    }

    public function feedback(Request $request): \Illuminate\Http\Response
    {
        $maintenance = Maintenance::where('preference_id', '=', $request->get('preference_id'))->get();
        if ($maintenance[0]->feedback_status === 1) {
            return response(['ERROR' => 'PREFERENCE_ID PROCESADO CON ANTERIORIDAD']);
        }

        $maintenance = Maintenance::find($maintenance[0]->id);
        $maintenance->collection_id = $request->get('collection_id');
        $maintenance->collection_status = $request->get('collection_status');
        $maintenance->payment_id = $request->get('payment_id');
        $maintenance->status = $request->get('status');
        $maintenance->external_reference = $request->get('external_reference');
        $maintenance->payment_type = $request->get('payment_type');
        $maintenance->merchant_order_id = $request->get('merchant_order_id');
        $maintenance->preference_id = $request->get('preference_id');
        $maintenance->site_id = $request->get('site_id');
        $maintenance->processing_mode = $request->get('processing_mode');
        $maintenance->merchant_account_id = $request->get('merchant_account_id');

        $maintenance->feedback_status = 1;
        $maintenance->save();

        if ($request->get('status') === 'approved') {

            Mail::send(new MaintenanceFeedbackMail($maintenance));
        }

        return response()->view('responses.maintenance_feedback_success',
            [
                'maintenance' => $maintenance
            ]
        );

    }

    public function paypalPreference(Request $request)
    {
        $request->validate([
            'quantity' => 'required',
            'price' => 'required',
        ]);

        $product = Product::find($request->get('id'));

        $paypalClient = new PayPalClient();
        $arrayBody = [
            'intent' => 'CAPTURE',
            'application_context' => [
                'brand_name' => "INAGAVE",
                'locale' => 'es-MX',
                'landing_page' => 'NO_PREFERENCE',
                'shipping_preference' => 'NO_SHIPPING',
                'user_action' => 'PAY_NOW',
                "cancel_url" => env('APP_URL') . "/api/paypal/checkout/maintenance/feedback" .
                    "?type=cancel",
                "return_url" => env('APP_URL') . "/api/paypal/checkout/maintenance/feedback" .
                    "?type=return"
            ],
            'purchase_units' => [
                [
                    'description' => 'PAGO DE MANTENIMIENTO - ' .$product->created_at,
                    'soft_descriptor' => 'INAGAVE',
                    'amount' => [
                        'currency_code' => 'MXN',
                        'value' => $request->get('price'),
                    ]
                ]
            ],
        ];
        $result = $paypalClient->createOrder($arrayBody);

        $maintenance = new Maintenance();
        $maintenance->product_id = $product->id;
        $maintenance->price = $request->get('price');
        $maintenance->quantity = $product->quantity;
        $maintenance->total = (float)$request->get('price') * (float)$product->quantity;

        $maintenance->type = 'PayPal';
        $maintenance->preference_id = $result->result->id;
        $maintenance->preference_status = 1;
        $maintenance->feedback_status = 0;
        $maintenance->start_date = now();
        $maintenance->end_date = now()->addYear();;
        $maintenance->save();

        Mail::send(new CreateMaintenancePreferenceMail($maintenance));

        return response()->json($result);
    }

    public function paypalFeedback(Request $request)
    {
        $maintenance = Maintenance::where('preference_id', '=', $request->get('token'))->get();
        if ($maintenance[0]->feedback_status === 1) {
            return response(['ERROR' => 'PREFERENCE_ID PROCESADO CON ANTERIORIDAD']);
        }

        $paypalClient = new PayPalClient();
        $result = $paypalClient->getOrder($request->get("token"));

        $maintenance = Maintenance::find($maintenance[0]->id);
        $maintenance->collection_id = $result->result->id;
        $maintenance->collection_status =  $result->result->status;
        $maintenance->payment_id = $result->result->id;
        $maintenance->status = $result->result->status;
        $maintenance->external_reference = 'PayPal';
        $maintenance->payment_type = 'PayPal';
        $maintenance->merchant_order_id = $result->result->payer->payer_id;
        $maintenance->preference_id =  $result->result->payer->payer_id;
        $maintenance->site_id = $result->result->payer->email_address;
        $maintenance->processing_mode = 'PayPal';
        $maintenance->merchant_account_id = $result->result->payer->payer_id;

        $maintenance->feedback_status = 1;
        $maintenance->save();

        if ($result->result->status === 'APPROVED') {

            Mail::send(new MaintenanceFeedbackMail($maintenance));
        }

        return response()->view('responses.maintenance_feedback_success',
            [
                'maintenance' => $maintenance
            ]
        );

    }
}
