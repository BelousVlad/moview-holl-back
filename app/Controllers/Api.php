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
			$order_by = $request->getGet('order_by');
			if ($order_by)
				$order_by = $this->getAppropriateMovieField($order_by);
			$movies = $movie_model->findAll($limit, $offset, $genre, $category, $order_by);
			// var_dump($movies);
		}
		return $this->response->setJSON($movies);
		// var_dump($movies);
	}

	private function getAppropriateMovieField($field)
	{
		if($field == 'id')
			return 'megogo_id';
		return $field; 
	}
	private function getAppropriateGenreField($field)
	{
		if($field == 'id')
			return 'genre_id';
		return $field; 
	}

	public function categories()
	{
		$model = model('App\Models\Category');

		$categories = $model->findAll();

		return $this->response->setJSON($categories);
	}
	public function genres($needly = null, $field = 'id')
	{
		$model = model('App\Models\Genre');
		if($needly)
		{
			$field = $this->getAppropriateGenreField($field);
			$genres = $model->find($needly, $field);
		}
		else
		{
			$genres = $model->findAll();
		}

		return $this->response->setJSON($genres);
	}
}
