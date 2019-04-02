<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Dnetix\Redirection\PlacetoPay;
use StdClass;


class PseController extends Controller
{
    // Creating a random reference for the test

    public function test()
    {


        /*error_reporting(E_ALL);

        $url = 'https://test.placetopay.com/redirection/';
        $secretKey = '024h1IlD';
        $login = "6dd490faf9cb87a9862245da41170ff2";
        //$result = "No se pudo obtener la lista de Entidades Financieras, por favor intente más tarde";

        if (function_exists('random_bytes')) {
            $nonce = bin2hex(random_bytes(16));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $nonce = bin2hex(openssl_random_pseudo_bytes(16));
        } else {
            $nonce = mt_rand();
        }
        $seed = date('c');
        $tranKey = base64_encode(sha1($nonce . $seed . $secretKey, true));


        $headers = array(
            'Content-Type: application/json; charset=utf-8'
        );

        // Open connection
        //return ($fields);
        $ch = curl_init();

        $login = [
            'login' => $login,
            'tranKey' => $tranKey,
            'nonce' => base64_encode($nonce),
            'seed' => $seed
        ];

        $auth = [
            'auth' => $login
        ];

        $fields = [
            'auth' => $login,
            "payment" => [
                "reference" => "5976030f5575d",
                "description" => "Pago básico de prueba",
                "amount" => [
                    "currency" => "COP",
                    "total" => "10000"
                ]
            ],
            "expiration" => "2019-08-01T00:00:00-05:00",
            "returnUrl" => "https://dev.placetopay.com/redirection/sandbox/session/5976030f5575d",
            "ipAddress" => "127.0.0.1",
            "userAgent" => "PlacetoPay Sandbox"
        ];

        echo var_dump(json_encode($fields));

        // para crear pago basico api/session

        $url .= 'api/session';
        $headers = ['Content-Type: application/json'];
        //exit();



        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);


        // Execute post
        $result = curl_exec($ch);
        echo var_dump($result);
        */


        $reference = 'TEST_' . time();
        // Request Information
        $request = [
            "locale" => "es_CO",
            "payer" => [
                "name" => "Kellie Gerhold",
                "surname" => "Yost",
                "email" => "flowe@anderson.com",
                "documentType" => "CC",
                "document" => "1848839248",
                "mobile" => "3006108300",
                "address" => [
                    "street" => "703 Dicki Island Apt. 609",
                    "city" => "North Randallstad",
                    "state" => "Antioquia",
                    "postalCode" => "46292",
                    "country" => "US",
                    "phone" => "363-547-1441 x383"
                ]
            ],
            "buyer" => [
                "name" => "Kellie Gerhold",
                "surname" => "Yost",
                "email" => "flowe@anderson.com",
                "documentType" => "CC",
                "document" => "1848839248",
                "mobile" => "3006108300",
                "address" => [
                    "street" => "703 Dicki Island Apt. 609",
                    "city" => "North Randallstad",
                    "state" => "Antioquia",
                    "postalCode" => "46292",
                    "country" => "US",
                    "phone" => "363-547-1441 x383"
                ]
            ],
            "payment" => [
                "reference" => $reference,
                "description" => "Iusto sit et voluptatem.",
                "amount" => [
                    "taxes" => [
                        [
                            "kind" => "ice",
                            "amount" => 56.4,
                            "base" => 470
                        ],
                        [
                            "kind" => "valueAddedTax",
                            "amount" => 89.3,
                            "base" => 470
                        ]
                    ],
                    "details" => [
                        [
                            "kind" => "shipping",
                            "amount" => 47
                        ],
                        [
                            "kind" => "tip",
                            "amount" => 47
                        ],
                        [
                            "kind" => "subtotal",
                            "amount" => 940
                        ]
                    ],
                    "currency" => "USD",
                    "total" => 1076.3
                ],
                "items" => [
                    [
                        "sku" => 26443,
                        "name" => "Qui voluptatem excepturi.",
                        "category" => "physical",
                        "qty" => 1,
                        "price" => 940,
                        "tax" => 89.3
                    ]
                ],
                "shipping" => [
                    "name" => "Kellie Gerhold",
                    "surname" => "Yost",
                    "email" => "flowe@anderson.com",
                    "documentType" => "CC",
                    "document" => "1848839248",
                    "mobile" => "3006108300",
                    "address" => [
                        "street" => "703 Dicki Island Apt. 609",
                        "city" => "North Randallstad",
                        "state" => "Antioquia",
                        "postalCode" => "46292",
                        "country" => "US",
                        "phone" => "363-547-1441 x383"
                    ]
                ],
                "allowPartial" => false
            ],
            "expiration" => date('c', strtotime('+1 hour')),
            "ipAddress" => "127.0.0.1",
            "userAgent" => "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.86 Safari/537.36",
            "returnUrl" => "http://dnetix.dev/p2p/client",
            "cancelUrl" => "https://dnetix.co",
            "skipResult" => false,
            "noBuyerFill" => false,
            "captureAddress" => false,
            "paymentMethod" => null
        ];
        $url = env('URL');
        //$result = "No se pudo obtener la lista de Entidades Financieras, por favor intente más tarde";
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $nonce = substr(str_shuffle($permitted_chars), 0, 16);
        $seed = date('Y-m-d\TH:i:s\Z');

        try {
            //$obj = new SoapClient($url);
            //$obj = new GuzzleHttp\Client(['base_uri' => $url]);
            $trankey  = base64_decode(sha1($nonce . $seed . env('TRAN_KEY')));
            $noce = base64_decode($nonce);
            $placetopay = new PlacetoPay([
                'login' => env('LOGIN'),
                'tranKey' => env('TRAN_KEY'),
                'url' => $url,
            ]);
            $response = $placetopay->request($request);


            return view('welcome', compact('request'));
        } catch (Exception $fault) {
            return view('welcome', compact('response'));
        }
    }

    public function info_response()
    {

        $soap_client = new SoapClient(env('URL_WSDL'));
        $tran_info = new StdClass();
        $auth = \Cache::get('auth');
        $tran_info = $auth;
        $tran_info->transactionID = \Cache::get('tran_id');
        $result_tran = $soap_client->getTransactionInformation($tran_info);

        $msj = $result_tran->getTransactionInformationResult->responseReasonText;

        return view('response', compact('msj'));
        //dd($result_tran);
    }
}
