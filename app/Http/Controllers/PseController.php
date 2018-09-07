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
  public function landing_form(Request $request)
  {

  	$id_bank= $request->id_bank;
	  \Cache::put('id_bank', $id_bank, 30);
	 
  	return view('landing_form');
  }

  public function form_user_fun()
  {  	
	  $id_bank=\Cache::get('id_bank');
	 
  	return view('form_user');
  }
}
