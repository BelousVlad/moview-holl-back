<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UaLocalization extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'movie_id' => [
				'type' => 'INT'
			],
			'title' => [
				'type' => 'varchar(256)',
			],
			'country' => [
				'type' => 'varchar(256)'
			],
			'page_url' => [
				'type' => 'varchar(256)'
			],
			'director' => [
				'type' => 'varchar(256)'
			],
			'actors' => [
				'type' => 'varchar(1024)'
			],
			'description' => [
				'type' => 'TEXT'
			]
		]);
		
		$this->forge->addPrimaryKey('movie_id');
		$this->forge->addForeignKey('movie_id', 'movies', 'movie_id', 'CASCADE', 'CASCADE');
		$this->forge->createTable('localization_uk_movies');
	}

	public function down()
	{
		//
	}
}
