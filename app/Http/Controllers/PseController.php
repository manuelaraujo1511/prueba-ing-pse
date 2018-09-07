<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use SoapClient;
use SoapVar;
use StdClass;

class Authentication{
	public $login;
	public $tranKey;
	public $seed;
}
class PseController extends Controller
{
  public function responseBanckList()
  {
  	$url = env('URL_WSDL');
  	$result = "No se pudo obtener la lista de Entidades Financieras, por favor intente más tarde";
  	try{
  		$obj = new SoapClient($url);
  	  
  		$login = env('LOGIN');
  		$tranKey = env('TRAN_KEY');  		
  		
  		$seed = date('c');

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
  		 
  		$result = \Cache::get('search');
  		
  		return view('welcome',compact('result'));

  		
  	}
  	catch(SoapFault $fault) {
  		return view('welcome',compact('result'));
  	}

  }

  public function info_response(){
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
  	
  	$msj= $result_tran->getTransactionInformationResult->responseReasonText;
  	
  	return view('response',compact('msj'));
  	//dd($result_tran);
  }
 
}
