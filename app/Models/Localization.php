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
		$this->from($this->getTableName($needly_localization));
		return $this->get();
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
}
