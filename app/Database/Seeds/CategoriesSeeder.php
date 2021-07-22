<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategoriesSeeder extends Seeder
{
	public function run()
	{
		$bulder = $this->db->table('categories');
		$data = [
			[
				'category_title' => 'Новинки',
			],
			[
				'category_title' => 'Фильмы',
			],
			[
				'category_title' => 'Мультфильмы',
			],
			[
				'category_title' => 'Сериалы',
			],
			[
				'category_title' => 'Спорт',
			],
			[
				'category_title' => 'Шоу',
			],
		];

		$bulder->insertBatch($data);
	}
}
