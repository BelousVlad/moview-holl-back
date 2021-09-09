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

	public function get_slides()
	{
		$model = model('App\Models\Slides');

		$items = $model->findAll();

		return $this->response->setJSON($items);
	}

	public function save_slide()
	{
		$model_slider = model('App\Models\Slides');

		$slide = json_decode($this->request->getPost('slide'));
		$image = $this->request->getFile('image');
		if($image && $image->isValid()) {
			$new_name = $image->getRandomName();
			$image->move(WRITEPATH.'uploads/slides', $new_name);
			$slide->image = $new_name;
		}

		// var_dump($slide);

		$res = $model_slider->save([
			'title' => $slide->title,
			'note' => $slide->note,
			'link' => $slide->link,
			'link_text' => $slide->link_text,
			'slide_id' => $slide->slide_id,
		]);

		return $this->response->setJSON([
			'ok' => $res
		]);
	}

	public function remove_slide() {
		$model_slider = model('App\Models\Slides');
		
		$id = $this->request->getPost('slide_id');

		$res = $model_slider->delete($id);

		return $this->response->setJSON([
			'ok' => $res
		]);
	}

	public function image_slide($img) {
		// var_dump(WRITEPATH.'uploads/slides/'.$img);
		// dd($this->response);
		return $this->response->download(WRITEPATH.'uploads/slides/'.$img, null, true);
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