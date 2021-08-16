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
		$movie_model = model('App\Model\Movie');
		$localization_model = null;
		$locale = $this->request->getLocale();
		if($locale != 'ru')
		{
			$localization_model = model('App\Model\Localization');
		}

		if($id)
		{
			$movies = $movie_model->find($id);
			if($localization_model)
			{
				$movies_loc = $localization_model->getMovieLocalization($movies->id, $locale);
				$this->setMovieLocale($movies, $movies_loc);
			}
		}
		else
		{
			$request = service('request');
			$limit = $request->getGet('limit') ?? 10;
			$offset = $request->getGet('offset') ?? 0;

			$category = $request->getGet('category');
			$vod = $request->getGet('vod');
			if($vod)
				$vod = explode(',', $vod);
			$genre = $request->getGet('genre');
			$order_by = $request->getGet('order_by');
			$title = $request->getGet('title');
			if ($order_by)
				$order_by = $this->getAppropriateMovieField($order_by);
			$movies = $movie_model->findAll($limit, $offset, $title, $vod, $genre, $category, $order_by);

			if($localization_model)
			{
				foreach($movies as $movie)
				{
					$movie_loc = $localization_model->getMovieLocalization($movie->movie_id, $locale);
					if ($movie_loc)
					{
						$this->setMovieLocale($movie, $movie_loc);
					}
				}
			}
		}

		return $this->response->setJSON($movies);
	}

	public function get_max()
	{
		$movies = model('App\Models\Movie');

		$genre = $this->request->getGet('genre');
		
		$count = $movies->getCount($genre);

		return $this->response->setJSON($count);
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

		$localization_model = null;
		$locale = $this->request->getLocale();
		if($locale != 'ru')
		{
			$localization_model = model('App\Model\Localization');
		}

		if($needly)
		{
			$field = $this->getAppropriateGenreField($field);
			$genres = $model->find($needly, $field);
			if ($localization_model)
				$genres->title = $localization_model->localizeGenre($genres->title);
		}
		else
		{
			$genres = $model->findAll();
			if ($localization_model)
				foreach($genres as $genre)
				{
					$genre->title = $localization_model->localizeGenre($genre->title);
				}
		}

		return $this->response->setJSON($genres);
	}

	public function add_slide()
	{

		var_dump($_SERVER['REMOTE_ADDR']);

		$title = $this->request->getPost('title');
		$note = $this->request->getPost('note');
		$link = $this->request->getPost('link');
		$link_text = $this->request->getPost('link_text');

		$model_slider = model('App\Models\Slides');

		var_dump($title);
		var_dump($note);
		var_dump($link);
		var_dump($link_text);

		// $model_slider->save([
		// 	'title' => $title,
		// 	'note' => $note,
		// 	'link' => $link,
		// 	'link_text' => $link_text,
		// ]);
	}

	public function get_slides()
	{
		$model = model('App\Models\Slides');

		$items = $model->findAll();

		return $this->response->setJSON($items);
	}

	public function save_slide()
	{
		var_dump($_SERVER['REMOTE_ADDR']);

		$id = $this->request->getPost('id');
		$title = $this->request->getPost('title');
		$note = $this->request->getPost('note');
		$link = $this->request->getPost('link');
		$link_text = $this->request->getPost('link_text');

		$model_slider = model('App\Models\Slides');

		var_dump($id);
		var_dump($title);
		var_dump($note);
		var_dump($link);
		var_dump($link_text);

		// $model_slider->save([
		// 	'id' => $id
		// 	'title' => $title,
		// 	'note' => $note,
		// 	'link' => $link,
		// 	'link_text' => $link_text,
		// ]);
	}

	private function setMovieLocale(&$movie, $locale)
	{
		$movie->title = 		$locale->title;
		$movie->actors = 		$locale->actors;
		$movie->country = 		$locale->country;
		$movie->description = 	$locale->description;
		$movie->director = 		$locale->director;
		$movie->page_url = 		$locale->page_url;
		$movie->genres = 		$locale->genres;
	}
}