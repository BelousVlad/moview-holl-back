<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Movie extends Entity
{
	protected $datamap = [
		'id' => 'movie_id',
		'title' => 'title',
		'country' => 'country',
		'year' => 'year',
		'page_url' => 'page_url',
		'premier_date' => 'premier_date',
		'vod' => 'vod',
		'director' => 'director',
		'actors' => 'actors',
		'imdb' => 'imdb',
		'duraction' => 'duraction',
		'description' => 'description'
	];
	protected $dates   = [
		'created_at',
		'updated_at',
		'deleted_at',
	];
	protected $casts   = [];
}
