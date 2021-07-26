<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Api extends BaseController
{
	public function index()
	{
		echo 123;
	}

	public function movie($id = false)
	{
		// var_dump($id);
		$movie_model = model('App\Model\Movie');

		if($id)
		{
			$movies = $movie_model->find($id);
		}
		else
		{
			$request = service('request');
			$limit = $request->getGet('limit') ?? 10;
			$offset = $request->getGet('offset') ?? 0;

			$category = $request->getGet('category');
			$genre = $request->getGet('genre');

			// var_dump($query->getCompiledSelect());
			$movies = $movie_model->findAll($limit, $offset, $genre, $category);
			// var_dump($movies);
		}
		return $this->response->setJSON($movies);
		// var_dump($movies);
	}

	public function categories()
	{
		$model = model('App\Models\Category');

		$categories = $model->findAll();

		return $this->response->setJSON($categories);
	}
}
