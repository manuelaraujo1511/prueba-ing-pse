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
  		$result = $obj->getBankList($parameter);

  		/*
  		+"getBankListResult": {#434 ▼
  		   +"item": array:39 [▼
  		     0 => {#435 ▼
  		       +"bankCode": "0"
  		       +"bankName": "A continuación seleccione su banco"
  		     }
  		*/
  		return view('welcome',compact('result'));

  		
  	}
  	catch(SoapFault $fault) {
  		echo '<br>'.$fault;
  	}
    //return view('web.index');
  }
}
