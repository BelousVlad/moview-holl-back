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
				// 'genre_title_ua' => 'аніме'
			],
			[
				'title' => 'биографический',
			// 	'genre_title_ua' => 'біографічний'
			],
			// [
			// 	'genre_title' => 'боевик',
			// 	'genre_title_ua' => 'бойовик'
			// ],
			// [
			// 	'genre_title' => 'вестерн',
			// 	'genre_title_ua' => 'вестерн'
			// ],
			// [
			// 	'genre_title' => 'военный',
			// 	'genre_title_ua' => 'військовий'
			// ],
			// [
			// 	'genre_title' => 'детектив',
			// 	'genre_title_ua' => 'детектив'
			// ],
			// [
			// 	'genre_title' => 'детский',
			// 	'genre_title_ua' => 'дитячий'
			// ],
			// [
			// 	'genre_title' => 'драма',
			// 	'genre_title_ua' => ''
			// ],
			// [
			// 	'genre_title' => 'исторический',
			// 	'genre_title_ua' => 'історичний'
			// ],
			// [
			// 	'genre_title' => 'кинокомикс',
			// 	'genre_title_ua' => 'кінокомікс'
			// ],
			// [
			// 	'genre_title' => 'комедия',
			// 	'genre_title_ua' => 'комедія'
			// ],
			// [
			// 	'genre_title' => 'криминал',
			// 	'genre_title_ua' => 'кримінал'
			// ],
			// [
			// 	'genre_title' => 'комедия',
			// 	'genre_title_ua' => 'комедія'
			// ],
			// [
			// 	'genre_title' => 'мелодрама',
			// 	'genre_title_ua' => 'мелодрама'
			// ],
			// [
			// 	'genre_title' => 'мультфильм',
			// 	'genre_title_ua' => 'мультфільм'
			// ],
			// [
			// 	'genre_title' => 'приключения',
			// 	'genre_title_ua' => 'пригоди'
			// ],
			// [
			// 	'genre_title' => 'реалити-шоу',
			// 	'genre_title_ua' => 'реаліті шоу'
			// ],
			// [
			// 	'genre_title' => 'спорт',
			// 	'genre_title_ua' => ''
			// ],
			// [
			// 	'genre_title' => 'триллер',
			// 	'genre_title_ua' => 'трилер'
			// ],
			// [
			// 	'genre_title' => 'ужасы',
			// 	'genre_title_ua' => 'жахи'
			// ],
			// [
			// 	'genre_title' => 'фантастика',
			// 	'genre_title_ua' => ''
			// ],
			// [
			// 	'genre_title' => 'фэнтези',
			// 	'genre_title_ua' => 'фентезі'
			// ],
		];

		$bulder->insertBatch($data);
	}
}
