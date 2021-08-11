<?php

namespace App\Models;

use CodeIgniter\Model;

class Localization extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = '';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = [];

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

	public function getMovieLocalization($movie_id, string $needly_localization)
	{
		$builder = $this->db->table($this->getTableName($needly_localization));
		$builder->where('movie_id', $movie_id);
		$row = $builder->get()->getRow();
		
		if($row)
		{
			$movie_model = model('App\Models\Movie');
			$movie = $movie_model->genreRelation([$row])[0];

			$genres = $movie->genres;
			foreach($genres as $genre)
			{
				$genre->title = $this->localizeGenre($genre->title);
			}
		}

		return $row;
	}

	public function setMovieLocalization($movie_id, string $needly_localization, $data)
	{
		$builder = $this->db->table($this->getTableName($needly_localization));
		$builder->set('movie_id', $movie_id);
		$builder->set($data);
		return $builder->insert();
	}

	private function getTableName(string $localization)
	{
		return "localization_$localization".'_movies';
	}

	public function clear(string $loc)
	{
		$builder = $this->db->table($this->getTableName($loc));
		return $builder->emptyTable();
	}

	private $genre_ua = array(
		'Триллеры' 				=> 'Трилери',	
		'Зарубежные' 			=> 'Зарубіжні',	
		'Фэнтези' 				=> 'Фентезі',	
		'Драмы' 				=> 'Драми',
		'Исторические' 			=> 'Історичні',	
		'Комедии' 				=> 'Комедії',	
		'Мелодрамы' 			=> 'Мелодрами',	
		'Боевики' 				=> 'Бойовики',	
		'Криминал' 				=> 'Кримінал',	
		'Ужасы' 				=> 'Жахи',	
		'Детективы' 			=> 'Детективи',	
		'Наши' 					=> 'Наші',
		'Мюзиклы' 				=> 'Мюзикли',	
		'Короткометражные' 		=> 'Короткометражні',	
		'Фильмы' 				=> 'Фільми',	
		'Военные' 				=> 'Військові',	
		'Семейные' 				=> 'Сімейні',	
		'Приключения' 			=> 'Пригоди',	
		'Фантастика' 			=> 'Фантастика',	
		'Детские' 				=> 'Дитячі',	
		'Спортивные' 			=> 'Спортивні',	
		'Мультфильмы' 			=> 'Мультфільми',	
		'Мультсериалы' 			=> 'Мультсеріали',	
		'Полнометражные' 		=> 'Повнометражні',	
		'Музыкальные' 			=> 'Музичні',
		'Союзмультфильм'		=> 'Союзмультфільм',
		'Документальные'		=> 'Документальні',
		'Аниме'					=> 'Аніме',
		'Биография'				=> 'Біографія',
		'Комиксы'				=> 'Комікси',
		'Юмористические'		=> 'Гумористичні',
		'Анимация'				=> 'Анімація',
		'Вестерн'				=> 'Вестерн',
		'Для взрослых'			=> 'Для Дорослих',
		'Арт-хаус'				=> 'Арт-Хаус',
		'Фильм-нуар' 			=> 'Фільм-Нуар',
		'Для самых маленьких' 	=> 'Для Наймолодших',
		'Мультфильмы в 3D'		=> 'Мультфільми В 3D',
		'Фильмы в 3D'			=> 'Фільми В 3D',
	);

	public function localizeGenre($genre)
	{
		if(isset($this->genre_ua[$genre]))
			$str = $this->genre_ua[$genre];
		return $str ?? $genre;
	}
}
