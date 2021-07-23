<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Genre extends Entity
{
	protected $datamap = [
		'id' => 'genre_id',
		'title' => 'title'
	];
	protected $dates   = [
		'created_at',
		'updated_at',
		'deleted_at',
	];
	protected $casts   = [];
}
