<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('test', function(){
	return Response::json(array('error' => false, 'message' => 'works so far'), 200);
});

Route::get('check', function(){
	if(Auth::check()){
		$user = Auth::user();
		return Response::json(array('error' => false, 'user' => $user), 200);
	}else{
		return Response::json(array('error' => true, 'reason' => 'you are not logged in'), 200);
	}
});

Route::get('users', function(){
	$users = User::all();
	return Response::json(array('error' => false, 'users' => $users), 200);

});


Route::get('passwords', function(){
	$users = User::all();
	foreach($users as $user){
		echo $user->password;
	}
});



//index for list
Route::get('api/v1/photos', array('uses' => 'PhotoController@showPhotosIndex'));


Route::get('api/v1/photos/{user_id}', function ($user_id){
	$photos = Photo::where('user_id', $user_id)->get();

	if($user_id == Auth::user()->id){
		return Response::json(array('error' => false, 'edit' => true, 'photos' => $photos), 200);
	}else{
		return Response::json(array('error' => false, 'edit' => false, 'photos' => $photos), 200);
	}
});

Route::group(array('prefix' => 'api/v1/'), function(){
	Route::resource('myphotos', 'PhotoController');
});

Route::get('login', array('uses' => 'HomeController@showLogin'));

// route to process the form
Route::post('login', array('uses' => 'HomeController@doLogin'));

Route::post('register', array('uses' => 'HomeController@doRegister'));




Route::get('logout', array('uses' => 'HomeController@showLogout'));
Route::post('logout', array('uses' => 'HomeController@doLogout'));
Route::get('current_user', function(){
	if(Auth::check()){
		$user = Auth::user();
		return Response::json(array('error' => false, 'user' => $user), 200);
	}else{
		return 'you are logged out.';
	}
});