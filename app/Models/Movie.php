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
		'description'
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
			$relations = $genre_movie->where('movie_id', $movie->id)->findAll();
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
			$relations = $category_movie->where('movie_id', $movie->id)->findAll();
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

	public function findAll(int $limit = 0, int $offset = 0)
	{
		$data = parent::findAll($limit, $offset);
		$data = $this->categoryRelation($data);
		return $this->genreRelation($data);
	}
}
