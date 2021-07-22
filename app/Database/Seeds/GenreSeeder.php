<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GenreSeeder extends Seeder
{
	public function run()
	{
		$bulder = $this->db->table('genres');
		$data = [
			[
				'title' => 'аниме',
			],
			[
				'title' => 'биографический',
			],
			[
				'title' => 'боевик',
			],
			[
				'title' => 'вестерн',
			],
			[
				'title' => 'военный',
			],
			[
				'title' => 'детектив',
			],
			[
				'title' => 'детский',
			],
			[
				'title' => 'драма',
			],
			[
				'title' => 'исторический',
			],
			[
				'title' => 'кинокомикс',
			],
			[
				'title' => 'комедия',
			],
			[
				'title' => 'криминал',
			],
			[
				'title' => 'комедия',
			],
			[
				'title' => 'мелодрама',
			],
			[
				'title' => 'мультфильм',
			],
			[
				'title' => 'приключения',
			],
			[
				'title' => 'реалити-шоу',
			],
			[
				'title' => 'спорт',
			],
			[
				'title' => 'триллер',
			],
			[
				'title' => 'ужасы',
			],
			[
				'title' => 'фантастика',
			],
			[
				'title' => 'фэнтези',	
			],
		];

		$bulder->insertBatch($data);
	}
}
