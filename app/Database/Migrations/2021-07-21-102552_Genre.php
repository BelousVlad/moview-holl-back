<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Genre extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'genre_id' => [
				'type' => 'INT',
				'auto_increment' => TRUE
			],
			'title' => [
				'type' => 'varchar(256)'
			]
		]);
		
		$this->forge->addPrimaryKey('genre_id');

		$this->forge->createTable('genres');

		$this->forge->addField([
			'movie_genre_id' => [
				'type' => 'INT',
				'auto_increment' => TRUE
			],
			'movie_id' => [
				'type' => 'int',
			],
			'genre_id' => [
				'type' => 'int'
			]
		]);

		$this->forge->addPrimaryKey('movie_genre_id');

		$this->forge->addForeignKey('movie_id', 'movies', 'movie_id');
		$this->forge->addForeignKey('genre_id', 'genres', 'genre_id');

		$this->forge->createTable('movie_genre');
	}

	public function down()
	{
		$this->forge->dropTable('movie_genre');
		$this->forge->dropTable('genres');
	}
}
