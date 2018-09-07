<?php

use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return view('welcome');
});

Route::get('/pse','PseController@responseBanckList');
Route::get('/transaction/{id_bank}',function($id_bank){
	
	
	$pse_t = new StdClass();

	$pse_t->bankCode = $id_bank;
	$pse_t->bankInterface = '0';
	$pse_t->returnURL = 'http://localhost:8000/info';
	$pse_t->reference = '000000001';
	$pse_t->description = 'prueba de tranasaccion';
	$pse_t->language = 'ES';
	$pse_t->currency = 'COP';
	$pse_t->totalAmount = 100000.00;
	$pse_t->taxAmount = 10.00;
	$pse_t->devolutionBase = 10.00;
	$pse_t->tipAmount = 10.00;
	$pse_t->payer = new StdClass();
	$pse_t->payer->documentType= 'CE';
	$pse_t->payer->document='19200130';
	$pse_t->payer->firstName= 'Manuel';
	$pse_t->payer->lastName= 'Araujo';
	$pse_t->payer->company= 'PlaceToPay';
	$pse_t->payer->emailAddress= 'manuel.araujo1511@gmail.com';
	$pse_t->payer->address= 'Calle 30 #81 - 30';
	$pse_t->payer->city= 'Medellin';
	$pse_t->payer->province= 'Antioquia';
	$pse_t->payer->country= 'Colombia';
	$pse_t->payer->phone= '3137130787';
	$pse_t->payer->mobile= '3137130787';
	$pse_t->payer->postalCode= '000051';
	$pse_t->buyer = new StdClass();
	$pse_t->buyer->documentType= 'CE';
	$pse_t->buyer->document='19200130';
	$pse_t->buyer->firstName= 'Manuel';
	$pse_t->buyer->lastName= 'Araujo';
	$pse_t->buyer->company= 'PlaceToPay';
	$pse_t->buyer->emailAddress= 'manuel.araujo1511@gmail.com';
	$pse_t->buyer->address= 'Calle 30 #81 - 30';
	$pse_t->buyer->city= 'Medellin';
	$pse_t->buyer->province= 'Antioquia';
	$pse_t->buyer->country= 'Colombia';
	$pse_t->buyer->phone= '3137130787';
	$pse_t->buyer->mobile= '3137130787';
	$pse_t->buyer->postalCode= '000051';
	$pse_t->shipping = new StdClass();
	$pse_t->shipping->documentType= 'CE';
	$pse_t->shipping->document='19200130';
	$pse_t->shipping->firstName= 'Manuel';
	$pse_t->shipping->lastName= 'Araujo';
	$pse_t->shipping->company= 'PlaceToPay';
	$pse_t->shipping->emailAddress= 'manuel.araujo1511@gmail.com';
	$pse_t->shipping->address= 'Calle 30 #81 - 30';
	$pse_t->shipping->city= 'Medellin';
	$pse_t->shipping->province= 'Antioquia';
	$pse_t->shipping->country= 'Colombia';
	$pse_t->shipping->phone= '3137130787';
	$pse_t->shipping->mobile= '3137130787';
	$pse_t->shipping->postalCode= '000051';
	$pse_t->ipAddress= '127.0.0.1';
	$pse_t->userAgent= 'Mozilla/5.0 (X11; Linux x86_64) Chrome/52.0.2743.82 Safari/537.36';


	$soap_client = new SoapClient(env('URL_WSDL'));
	$auth = \Cache::get('auth');	
	$create = new StdClass();
	$create = $auth;
	$create->transaction = $pse_t;

	
	$result = $soap_client->createTransaction($create);

	if($result->createTransactionResult->returnCode=='SUCCESS'){
		$transaction_id =$result->createTransactionResult->transactionID;
		DB::table('transactions')->insert(['transaction_id'=> $transaction_id]);
		\Cache::forget('tran_id');
		\Cache::put('tran_id', $transaction_id, 10);
		
		

	}else{
		$result = $result->createTransactionResult->responseReasonText;
		return view('welcome',compact('result'));
	}
	
  	
  return Response::json($result);
	
});

Route::get('/info','PseController@info_response');