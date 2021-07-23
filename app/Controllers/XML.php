<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class XML extends BaseController
{
	public function index()
	{
		echo 321;
	}

	public function gen_database()
	{
		$movie_model = model('App\Models\Movie');
		$movie_category_model = model('App\Models\MovieCategory');
		$movie_genre_model = model('App\Models\MovieGenre');

		$xml = simplexml_load_file(ROOTPATH.'app/Controllers/movies.xml');

		$movie_genre_model->emptyTable();
		$movie_category_model->emptyTable();
		$movie_model->emptyTable();

		foreach($xml->object as $object)
		{
			$info = $object->info;
			// dd($object);
			$year = $info['year'];
			$country = $info['country'];
			$premier_date = $info['premiere'];
			// var_dump($object);
			// $attr = 'attributes';
			$title = $object['title'];
			$mgg_id = $object['id'];
			$page_url = $object['page'];
			$vod = $object['vod'];
			$imdb = $object->ratings['imdb'];
			
			$duraction = $object->duration_sec;
			// dd($object);
			$description = $object->story;
			$tmp = 'gallery-image';
			// var_dump($object);
			$gallery = $object->$tmp;
			
			$genres = $object['genres'];
			$categories = $object['categories'];
			$directors = $object->directors;
			$directors_str = '';
			
			foreach($directors as $director)
			{
				$directors_str.= $director->director.' ,';
			}

			$actors = $object->actors;
			$actors_str = '';
			
			foreach($actors as $actor)
			{
				$actors_str.= $actor->actor.' ,';
			}

			$genres_arr = explode(',', $genres);
			
			$genres_ids = array();
			foreach($genres_arr as $genre_title)
			{
				array_push($genres_ids, $this->addGenreIfNoExist($genre_title));
			}

			$categories_arr = explode(',', $categories);
			
			$categories_ids = array();
			foreach($categories_arr as $categorie_title)
			{
				array_push($categories_ids, $this->addCategoryIfNoExist($categorie_title));
			}
			$gallery_arr = array();
			foreach($gallery as $image)
			{
				array_push($gallery_arr, $image['url']);
			}

			$movie = new \App\Entities\Movie();

			$movie->title = $title;
			$movie->country = $country;
			$movie->year = $year;
			$movie->page_url = $page_url;
			$movie->premier_date = $premier_date;
			$movie->director = $directors_str;
			$movie->actors = $actors_str;
			$movie->imdb = $imdb;
			$movie->duraction = $duraction;
			$movie->description = $description;
			$movie->vod = $vod;

			// dd($movie);

			$movie_model->save($movie);
			$movie_id = $movie_model->insertID;

			// var_dump($movie_id);

			foreach($genres_ids as $id)
			{
				$arr = [
					'movie_id' => $movie_id,
					'genre_id' => $id
				];
				// var_dump($arr);
				$movie_genre_model->save($arr);
			}

			foreach($categories_ids as $id)
			{
				$movie_category_model->save([
					'movie_id' => $movie_id,
					'category_id' => $id
				]);
			}
		}
	}

	private function addGenreIfNoExist($title)
	{
		$genre_model = model('App\Models\Genre');

		$genre = $genre_model->where(array('title' => $title))->first();

		if($genre)
			return $genre->id;

		$genre = new \App\Entities\Genre();
		$genre->title = $title;

		$genre_model->save($genre);
		return $genre_model->insertID;
	}

	private function addCategoryIfNoExist($title)
	{
		$category_model = model('App\Models\Category');

		$category = $category_model->where(array('category_title' => $title))->first();

		if($category)
			return $category->id;

		$category = new \App\Entities\Category();
		$category->title = $title;

		$category_model->save($category);
		return $category_model->insertID;
	}
}
