<?php

class PhotoController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Auth::check()){
			$photos = Photo::where('user_id', Auth::user()->id)->get();
			return Response::json(array('error' => false, 'edit' => true, 'photos' => $photos), 200);
		}else{
			return Response::json(array('error' => true, 'reason' => 'not logged in'), 200);
		}

	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('image_form');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$imageName = '';
		$imagePath = public_path() . '/img/';


		if (Input::hasFile('photo'))
			{
			    $img = Input::file('photo');


			    $imageName = str_random(6) . '_' . $img->getClientOriginalName();


			    
			    $img->move($imagePath, $imageName);
			    $img = Image::make($imagePath . $imageName);
			    $img->save($imagePath . $imageName);
			    

			    $thumb = Image::make($imagePath . $imageName);
			    $thumbName = $imageName;
			    $thumbPath = public_path() . '/thumbs/img/';
			    $thumb->resize(100, 100);
			    $thumb->save($thumbPath . $thumbName);

			    
			    $imgEntry = new Photo;
			    $imgEntry->user_id = Auth::user()->id;
			    $imgEntry->caption = Input::get('caption');
			    $imgEntry->path = 'img/' . $imageName;
			    $imgEntry->save();


			    return Response::json(array('error' => false, 'message' => 'Upload successful.'), 200);
			}else{
				return Response::json(array('error' => 'true', 'photos' => null), 200);
			}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$photos = Photo::where('id', $id)
			->take(1)
			->get();

		return Response::json(array('error' => false, 'photos' => $photos), 200);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$photo = Photo::where('id', $id);
		$photo->delete();

		return Response::json(array('error' => false, 'message' => 'photo deleted'), 200);
	}
	
	//show index of users
	public function showPhotosIndex(){
		
		if(Auth::check()){
			$userId = Auth::user()->id;
			$photos = Photo::all();
			$firstPhotos = array();
			$users = array();

			foreach($photos as $photo){
				if(!in_array($photo->user_id, $users) && $userId != $photo->user_id){
					array_push($firstPhotos, $photo);
					array_push($users, $photo->user_id);
				}
			}
		return Response::json(array('error' => false, 'photos' => $firstPhotos), 200);
		}else{
			return Response::json(array('error' => true, 'reason' => 'not logged in'), 200);
		}

	}


}