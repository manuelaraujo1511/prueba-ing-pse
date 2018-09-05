<?php

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

Route::get('/pse', function () {
  $url = "https://test.placetopay.com/soap/pse/?wsdl";
  try{
  	$client = new SoapClient($url,['trace' => 1, 'cache_wsdl' => WSDL_CACHE_NONE, 'user_agent' => 'Mi cliente SOAP']);
  	//dd($client->GetCitiesByCountry(['CountryName' => 'Peru'])->GetCitiesByCountryResult);
  	dd($client->__getTypes());
  }
  catch(SoapFault $fault) {
  	echo '<br>'.$fault;
  }
});