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
  	$url = "https://test.placetopay.com/soap/pse/?wsdl";
  	$result = "No se pudo obtener la lista de Entidades Financieras, por favor intente más tarde";
  	try{
  		$obj = new SoapClient($url);
  	  		
  		$login = '6dd490faf9cb87a9862245da41170ff2';
  		$tranKey = '024h1IlD';  		
  		
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
	      \Cache::put('search', $result, 1440);
	    }
  		 
  		
  		//dd(C);
  		

  		/*
  		+"getBankListResult": {#434 ▼
  		   +"item": array:39 [▼
  		     0 => {#435 ▼
  		       +"bankCode": "0"
  		       +"bankName": "A continuación seleccione su banco"
  		     }
  		*/
  		$result = \Cache::get('search');
  		/*foreach ($result->getBankListResult->item as $key => $v) {
  			dd($v->bankName);
  		}*/
  		
  		return view('welcome',compact('result'));

  		
  	}
  	catch(SoapFault $fault) {
  		return view('welcome',compact('result'));
  	}
    //return view('web.index');
  }
}
