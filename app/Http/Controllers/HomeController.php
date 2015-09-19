<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}

	public function showLogin(){
		return View::make('login');
	}

	public function doLogin()
	{
		$userdata = array(
			'username' 	=> Input::get('username'),
			'password' 	=> Input::get('password')
		);

		if (Auth::attempt($userdata)) {
			$user = Auth::user();

			return Response::json(array('error' => false, 'username' => $user->username), 200);

		} else {	 	

			return Response::json(array('error' => true, 'reason' => 'login failed'), 200);

		}
	}

	public function showLogout(){
		return View::make('logout');
	}

	public function doLogout(){
		Auth::logout();
		return Response::json(array('error' => false, 'message' => 'you are logged out.'), 200);
	}

	public function doRegister(){

		$username = Input::get('username');
		$password = Input::get('password');
		$password = Hash::make($password);

		if($username != "" && $password != ""){

			$users = User::all();
			$usernames = array();
			foreach($users as $user){
				$usernames[] = $user->username;
			}


			if(!in_array($username, $usernames)){
				$user = new User;
				$user->username = $username;
				$user->password = $password;
				$user-> save();

				$userdata = array(
					'username' 	=> Input::get('username'),
					'password' 	=> Input::get('password')
				);

				if (Auth::attempt($userdata)) {
					$user = Auth::user();
					return Response::json(array('error' => false, 'userdata' => $user), 200);
				}else{
					return Response::json(array('error' => true, 'reason' => 'login failed'), 200);
				}

			}else{
				return Response::json(array('error' => true, 'reason' => 'username not unique'), 200);
			}
		}else{
			return Response::json(array('error' => true, 'reason' => 'username or password is empty'), 200);
		}
	}


}