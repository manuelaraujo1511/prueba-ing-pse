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
			$trankey  = base64_decode(sha1($nonce.$seed.env('TRAN_KEY')));
			$noce = base64_decode($nonce);
			$placetopay = new PlacetoPay([
				'login' => env('LOGIN'),
				'tranKey' => env('TRAN_KEY'),
				'url' => $url,
			]);
			$response = $placetopay->request($request);
			/* $seed = date('c');

  		$tranKey = sha1( $seed.$tranKey , false );

  		$parameter = new StdClass();    

  		$parameter->auth = new StdClass();
  		$parameter->auth->login = $login;
  		$parameter->auth->tranKey = $tranKey;
  		$parameter->auth->seed = $seed;
  		
  		if (!\Cache::has('search')) {
	      $result = $obj->getBankList($parameter);
	      //almacenar en cache por un día
	      \Cache::put('soap_client', $obj, 1440);
	      \Cache::put('auth', $parameter, 1440);
	      \Cache::put('search', $result, 1440);
	    }
			
			$result = \Cache::get('search'); */



			return view('welcome', compact('request'));
		} catch (Exception $fault) {
			return view('welcome', compact('response'));
		}
	}

	public function info_response()
	{
		/*
  	{#454 ▼
  	  +"getTransactionInformationResult": {#455 ▼
  	    +"transactionID": 1461940579
  	    +"sessionID": "f2163fa64ce165c20f370eb01024b3d5"
  	    +"reference": "000000001"
  	    +"requestDate": "2018-09-06T22:38:24-05:00"
  	    +"bankProcessDate": "2018-09-06T22:38:50-05:00"
  	    +"onTest": true
  	    +"returnCode": "SUCCESS"
  	    +"trazabilityCode": "1466634"
  	    +"transactionCycle": 6
  	    +"transactionState": "OK"
  	    +"responseCode": 1
  	    +"responseReasonCode": "00"
  	    +"responseReasonText": "Aprobada"
  	  }
  	}

  	*/
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
