<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MoviesSeeder extends Seeder
{
	public function run()
	{
		$moviesTable = $this->db->table('movies');
		$movieCategoryTable = $this->db->table('movie_category');

		$data = [
			[
				'title' => 'Боевой робот номер 4',
				'country' => 'США',
				'year' => '2020',
				'page_url' => 'https://www.google.com/',
				'premier_date' => '2020',
				'vod' => '',
				'director' => 'Марк Тойя',
				'actors' => ' Антонио Бандерас, Роберт Дауни мл., Крэйг Робинсон, Майкл Шин, Эмма Томпсон, Марион Котийяр, Рэйф Файнс, Джон Сина, Октавия Спенсер, Том Холланд, Касия Смутняк, Селена Гомес, Стюарт Скудамор, Мэтт Кинг, Джим Бродбент, Келли Стейблз, Джейсон Манцукас, Кумэйл Нанджиани, Ричард Прайс, Тоня Корнелисс, Ральф Айнесон, Клайв Брант, Клайв Фрэнсис, Рами Малек, Джесси Бакли, Фрэнсис де ла Тур',
				'imdb' => '5.3',
				'duraction' => '131',
				'description' => '',
				'genres' => [1, 3, 4],
				'gallery' => [
					'https://via.placeholder.com/250',
					'https://via.placeholder.com/250',
					'https://via.placeholder.com/250',
					'https://via.placeholder.com/250',
				],
				'categories' => [2, 3, 4],
			]
		];
	}
}
