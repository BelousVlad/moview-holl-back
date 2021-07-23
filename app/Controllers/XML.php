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
		// echo 123;
		// var_dump();
		// var_dump($this->addGenreIfNoExist('Мелодрамы'));

		$xml = simplexml_load_file(ROOTPATH.'app/Controllers/movies.xml');

		// var_dump($xml);

		foreach($xml->object as $object)
		{
			// var_dump($object);
			// $attr = 'attributes';
			$title = $object['title'];
			$mgg_id = $object['id'];
			$page_url = $object['page'];
			$vod = $object['vod'];
			$premier_date = $object['premier'];
			$imdb = $object['imdb'];
			$duraction = $object['duraction'];
			$description = $object['description'];
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
				// var_dump($image);
				array_push($gallery_arr, $image['url']);
				// echo $image	['url'].'<br>';
			}
			// echo '<br>';
			// var_dump($gallery_arr);

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
