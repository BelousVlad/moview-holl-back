<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use DateTime;
use DateTimeZone;

class XML extends BaseController
{
	public function index()
	{
		
	}

	private $en_months = [
		'January',
		'February',
		'March',
		'April',
		'May',
		'June',
		'July',
		'August',
		'September',
		'October',
		'November',
		'December',
	];
	private $ru_months = [
		'января',
		'февраля',
		'марта',
		'апреля',
		'мая',
		'июня',
		'июля',
		'августа',
		'сентября',
		'октября',
		'ноября',
		'декабря',
	];

	public function gen_database()
	{
		$movie_model = model('App\Models\Movie');
		$movie_category_model = model('App\Models\MovieCategory');
		$movie_genre_model = model('App\Models\MovieGenre');
		$movie_gallery = model('App\Models\Gallery');

		$xml = simplexml_load_file('http://xml.megogo.net/assets/files/ua/all_embed_mgg.xml');

		$movie_genre_model->emptyTable();
		$movie_category_model->emptyTable();
		$movie_gallery->emptyTable();
		$movie_model->emptyTable();

		// echo(date_create_from_format("j F Y",'9 сентября 2009', DateTimeZone::EUROPE) . "<br>");

		// $limit = 50;

		foreach($xml->object as $object)
		{
			$info = $object->info;
			$id = trim($object['id']);
			
			$year = $info['year'];
			$country = $info['country'];

			$premier_date = $info['premiere'];
			$premier_date = str_ireplace($this->ru_months, $this->en_months, $premier_date);
			
			$premier_date = DateTime::createFromFormat("j F Y", $premier_date, new DateTimeZone('Europe/Kiev'));
			
			if($premier_date === false)
				$premier_date = null;
			else
				$premier_date = $date = date('Y-m-d', $premier_date->getTimestamp());

			$title = $object['title'];
			$mgg_id = $object['id'];
			$page_url = $object['page'];
			$vod = $object['vod'];
			$imdb = $object->ratings['imdb'];

			$poster_obj = $object->poster;
			$poster = $poster_obj['thumbnail'];
			
			$duraction = $object->duration_sec;
			$description = $object->story;
			$tmp = 'gallery-image';
			$gallery = $object->$tmp;
			
			$genres = $object['genres'];
			$categories = $object['categories'];
			$directors = $object->directors;
			$directors_str = '';

			if(stripos($categories,'Передачи и шоу') !== false)
				continue;
			
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
				array_push($genres_ids, $this->addGenreIfNoExist(trim($genre_title)));
			}

			$categories_arr = explode(',', $categories);
			
			$categories_ids = array();
			foreach($categories_arr as $categorie_title)
			{
				array_push($categories_ids, $this->addCategoryIfNoExist(trim($categorie_title)));
			}

			$gallery_arr = array();
			foreach($gallery as $image)
			{
				array_push($gallery_arr, $image['url']);
			}

			$movie = new \App\Entities\Movie();

			$movie->megogo_id = $id;
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
			$movie->poster = $poster;

			// dd($movie);

			$movie_model->save($movie);
			$movie_id = $movie_model->insertID;

			foreach($genres_ids as $id)
			{
				$arr = [
					'movie_id' => $movie_id,
					'genre_id' => $id
				];
				$movie_genre_model->save($arr);
			}

			foreach($categories_ids as $id)
			{
				$movie_category_model->save([
					'movie_id' => $movie_id,
					'category_id' => $id
				]);
			}

			foreach($gallery_arr as $url)
			{
				$movie_gallery->save([
					'movie_id' => $movie_id,
					'gallery_img' => $url
				]);
			}
		}

		$this->parse_ua_movies();
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

	public function parse_ua_movies()
	{
		$movie_model = model('App\Models\Movie');
		$localization_model = model('App\Models\Localization');

		$localization_model->clear('uk');

		$xml = simplexml_load_file('http://xml.megogo.net/assets/files/ua/all_mgg_ua.xml');

		// $i = 100;

		foreach($xml->object as $object)
		{
			$info = $object->info;
			$id = trim($object['id']);
			
			$country = $info['country'];
			$title = $object['title'];
			$description = $object->story;
			$page_url = $object['page'];
			
			$genres = $object['genres'];
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

			$movie = $movie_model
				->where('megogo_id', $id)
				->first();

			if ($movie)
			{
				$data = array(
					'title' => $title,
					'country' => $country,
					'page_url' => $page_url,
					'director' => $directors_str,
					'actors' => $actors_str,
					'description' => $description,	
				);
				
				$res = $localization_model->setMovieLocalization($movie->id, 'uk', $data);
			}
			
		}
	}
}
