<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Category extends Entity
{
	protected $datamap = [
		'id' => 'category_id',
		'title' => 'category_title'
	];
	protected $dates   = [
		'created_at',
		'updated_at',
		'deleted_at',
	];
	protected $casts   = [];
}
