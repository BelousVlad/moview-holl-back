<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		$model = model('App\Models\Movie');

		// $model->save(array('title' => 'test_title'));

		$genres = $model->findAll();

		var_dump($genres);

		// $genre->title = 'new_title2';

		// $model->save($genre);
		// return view('welcome_message');
	}
}
