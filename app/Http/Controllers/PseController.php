<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
