<?php

namespace App\Classes;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Core\SandboxEnvironment as Environment;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalHttp\HttpException;

//use PayPalCheckoutSdk\Core\ProductionEnvironment;

class PayPalClient
{
    /**
     * @return PayPalHttpClient
     */
    public static function client()
    {
        return new PayPalHttpClient(self::environment());
    }

    /**
     * @return Environment
     */
    public static function environment()
    {
        $clientId = getenv("PAYPAL_CLIENT_ID");
        $clientSecret = getenv("PAYPAL_CLIENT_SECRET");
        return new Environment($clientId, $clientSecret);
    }

    /**
     * @param bool $debug
     * @return \PayPalHttp\HttpResponse
     * EXAMPLE
     * Status Code: 201
     * Status: CREATED
     * Order ID: 5A88776902603730V
     * Intent: CAPTURE
     * Links:
     * self: https://api.sandbox.paypal.com/v2/checkout/orders/5A88776902603730V	Call Type: GET
     * approve: https://www.sandbox.paypal.com/checkoutnow?token=5A88776902603730V	Call Type: GET
     * update: https://api.sandbox.paypal.com/v2/checkout/orders/5A88776902603730V	Call Type: PATCH
     * capture: https://api.sandbox.paypal.com/v2/checkout/orders/5A88776902603730V/capture	Call Type: POST
     */
    public static function createOrder($arrayBody, $debug = false)
    {
        $client = self::client();

        $request = new OrdersCreateRequest();
        $request->prefer("return=representation");

        $request->body = $arrayBody;
        //Call PayPal to set up a transaction
        $response = null;
        try {
            $response = $client->execute($request);
            if ($debug) {
                print "Status Code: {$response->statusCode}\n";
                print "Status: {$response->result->status}\n";
                print "Order ID: {$response->result->id}\n";
                print "Intent: {$response->result->intent}\n";
                print "Links:\n";
                foreach ($response->result->links as $link) {
                    print "\t{$link->rel}: {$link->href}\tCall Type: {$link->method}\n";
                }
            }

        } catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }

        return $response;
    }

    /**
     * @param $orderId
     * @param bool $debug
     * @return array|string
     * EXAMPLE
     * Status Code: 201
     * Status: APPROVED
     * Order ID: 5A88776902603730V
     * Intent: CAPTURE
     * Links:
     * self: https://api.sandbox.paypal.com/v2/checkout/orders/5A88776902603730V	Call Type: GET
     * capture: https://api.sandbox.paypal.com/v2/checkout/orders/5A88776902603730V/capture	Call Type: POST
     * Gross Amount: MXN 220.00
     */
    public static function getOrder($orderId, $debug = false)
    {
        $client = self::client();
        try {
            $response = $client->execute(new OrdersGetRequest($orderId));

            if ($debug) {
                //print json_encode($response->result);
                print "Status Code: {$response->statusCode}\n";
                print "Status: {$response->result->status}\n";
                print "Order ID: {$response->result->id}\n";
                print "Intent: {$response->result->intent}\n";
                print "Links:\n";
                foreach ($response->result->links as $link) {
                    print "\t{$link->rel}: {$link->href}\tCall Type: {$link->method}\n";
                }
                print "Gross Amount: {$response->result->purchase_units[0]->amount->currency_code} {$response->result->purchase_units[0]->amount->value}\n";

            }
        } catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }

        return $response;
    }

    /**
     * @param $orderId
     * @param bool $debug
     * @return array|string
     * Status Code: 201
     * Id: 8GB67279RC051624C
     * Create_time: 2018-08-06T23:39:11Z
     * Update_time: 2018-08-06T23:39:11Z
     * Payer:
     * Name:
     * Given_name: test
     * Surname: buyer
     * Email_address: test-buyer@paypal.com
     * Payer_id: KWADC7LXRRWCE
     * Phone:
     * Phone_number:
     * National_number: 408-411-2134
     * Address:
     * Country_code: US
     * Links:
     * 1:
     * Href: https://api.sandbox.paypal.com/v2/checkout/orders/3L848818A2897925Y
     * Rel: self
     * Method: GET
     * Status: COMPLETED
     */
    public static function setOrderCaptureRequest($orderId, $debug = false)
    {
        $client = self::client();

        $request = new OrdersCaptureRequest($orderId);
        $request->prefer("return=representation");

        //Call PayPal to set up a transaction
        try {
            $response = $client->execute($request);

            if ($debug) {
                print_r($request);
            }
        } catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }

        return $response;
    }

}
