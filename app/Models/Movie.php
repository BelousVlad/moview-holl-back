<?php

namespace App\Models;

use CodeIgniter\Model;

class Movie extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'movies';
	protected $primaryKey           = 'movie_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'App\Entities\Movie';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
		'megogo_id',
		'title',
		'country',
		'year',
		'page_url',
		'premier_date',
		'vod',
		'director',
		'actors',
		'imdb',
		'duraction',
		'description',
		'poster',
	];

	// Dates
	protected $useTimestamps        = false;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

	protected function genreRelation(array $data)
	{
		// var_dump($data);
		$genre_movie = model('App\Model\MovieGenre');
		$genre_model = model('App\Model\Genre');

		foreach($data as $movie)
		{
			// var_dump($movie);
			$relations = $genre_movie->where('movie_id', $movie->movie_id)->findAll();
			$genres_arr = array();
			foreach($relations as $relation)
			{
				$genre = $genre_model->find($relation->genre_id);
				array_push($genres_arr, $genre);
			}
			$movie->genres = $genres_arr;
		}
		return $data;
	}

	protected function categoryRelation(array $data)
	{
		// var_dump($data);
		$category_movie = model('App\Model\MovieCategory');
		$category_model = model('App\Model\Category');

		foreach($data as $movie)
		{
			// var_dump($movie);
			$relations = $category_movie->where('movie_id', $movie->movie_id)->findAll();
			$categories_arr = array();
			foreach($relations as $relation)
			{
				$category = $category_model->find($relation->category_id);
				array_push($categories_arr, $category);
			}
			$movie->categories = $categories_arr;
		}
		return $data;
	}

	protected function galleryRelation(array $data)
	{
		$gallery = model('App\Model\Gallery');

		foreach($data as $movie)
		{
			// var_dump($movie);
			$relations = $gallery->where('movie_id', $movie->movie_id)->findAll();
			$gallery_arr = array();
			foreach($relations as $relation)
			{
				$img = $relation->gallery_img;
				array_push($gallery_arr, $img);
			}
			$movie->gallery = $gallery_arr;
		}
		return $data;
	}

	public function findAll(int $limit = 10, int $offset = 0, $genre = null, $category = null, $order_by = null)
	{
		if($category)
		{
			$this->join('movie_category', 'movie_category.movie_id = movies.movie_id');

			$this->where("movie_category.category_id = $category");
		}

		if($genre)
		{
			$this->join('movie_genre', 'movie_genre.movie_id = movies.movie_id');

			$this->where("movie_genre.genre_id = $genre");
		}

		if($order_by)
		{
			$this->orderBy($order_by, 'DESC');
		}

		$data = $this->get($limit, $offset)->getResult();
		$data = $this->categoryRelation($data);
		$data = $this->genreRelation($data);
		return $data;
	}

	public function find($id = null)
	{
		$movie = parent::find($id);
		$movie = $this->categoryRelation([$movie]);
		$movie = $this->genreRelation($movie);
		$movie = $this->galleryRelation($movie);

		return $movie[0];
	}
}
