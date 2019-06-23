<?php

/* Not Authentication routes */

Route::get('/', 'adminController@indexpage');
Route::get('/login', 'adminController@indexpage');
Route::post('/login', 'adminController@login');

Route::get('/logout', 'adminController@logout');
Route::get('/agentLogin','adminController@loginagent');

Route::get('/auto-create','adminController@autoGenerateNumber');

Route::get('/check-balance/{user_id}','adminController@checkBalance');
Route::get('/check-balance-main','adminController@checkBalanceMain');

Route::get('/all-balance','adminController@allBalance');

Route::group(array("prefix"=>'admin',"before"=>['auth','admin']),function(){
	
	Route::get('/', 'adminController@adminPage');
	Route::get('/stats', 'adminController@stats');

	Route::get('/addDis', 'adminController@addDis');
	Route::get('/transferhistory', 'adminController@transferhistory');
	Route::get('/alltransferhistory', 'adminController@alltransferhistory');
	Route::get('/latest', 'adminController@latest');
	Route::post('/postDis', 'adminController@postDis');

	Route::post('/addAgent', 'adminController@addAgent');
	Route::get('/agent/edit/{id}', 'adminController@editAgent');
	Route::get('/agent/delete/{id}', 'adminController@deleteAgent');
	Route::post('/agent/update/{id}', 'adminController@updateAgent');

	Route::get('/fundtransfer','adminController@fundtransfer');
	Route::post('/getpayee','adminController@getPayee');
	// Route::post('/transferMoney','adminController@transferMoney');
	Route::post('/makepayment','adminController@makepayment');
	Route::post('/makepaymentUser','adminController@makepaymentUser');
	

	Route::get('/bettinghistoryagent/{id}','adminController@bettinghistoryagent');
	Route::post('/bettinghistoryagent/{id}','adminController@bettinghistoryagent');

});

Route::group(array("before"=>'auth'),function(){

	Route::group(array("prefix"=>'admin'),function(){
		Route::get('/transferhistoryagent/{id?}','adminController@transferhistoryagent');
		Route::get('/transferhistoryuser/{id}','adminController@transferhistoryuser');
		Route::get('/transferhistorydis/{id}','adminController@transferhistorydis');


		Route::get('/bettinghistoryuser/{id}','adminController@bettinghistoryuser');
		Route::post('/bettinghistoryuser/{id}','adminController@bettinghistoryuser');
	});

	Route::get('/fundtransfer','adminController@fundtransfer');
	Route::post('/getpayee','adminController@getPayee');
	Route::post('/transferMoney','adminController@transferMoney');
	Route::post('/transferMoneyAgent','adminController@transferMoneyAgent');
	Route::post('/withdrawMoney','agentController@withdrawMoney');
	Route::get('/agents/transferhistoryagent','agentController@transferhistoryagent');
	Route::get('/agents/transferhistorydis','agentController@transferhistorydis');

	Route::get('/change-password','UserController@getUserProfile');
	Route::post('/change-password','UserController@postChangePassword');


});

Route::group(array("prefix"=>'agents',"before"=>['auth']),function(){
	Route::get('/', 'agentController@agentPage');

	// Route::group(array("before"=>['admin']),function(){
		Route::post('/addUser', 'agentController@addUser');
		Route::get('/edit_user/{id}', 'agentController@editUser');
		Route::get('/delete_user/{id}', 'agentController@deleteUser');
		Route::post('/update_user/{id}', 'agentController@updateUser');
		Route::post('/update_user/password/{id}', 'agentController@updateUserPassword');
	// });

});

Route::get('/check-redis/{key}','adminController@checkRedis');
Route::get('/clear-redis','adminController@clearRedis');
