<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Movies extends Migration
{
	public function up()
	{
		//
		$this->forge->addField([
			'movie_id' => [
				'type' => 'INT',
				'auto_increment' => TRUE
			],
			'title' => [
				'type' => 'varchar(256)',
			],
			'country' => [
				'type' => 'varchar(256)'
			],
			'year' => [
				'type' => 'INT',
			],
			'page_url' => [
				'type' => 'varchar(256)'
			],
			'premier_date' => [
				'type' => 'DATE'
			],
			'vod' => [
				'type' => 'varchar(20)'
			],
			'director' => [
				'type' => 'varchar(256)'
			],
			'actors' => [
				'type' => 'varchar(1024)'
			],
			'imdb' => [
				'type' => 'FLOAT'
			],
			'duraction' => [
				'type' => 'INT'
			],
			'description' => [
				'type' => 'TEXT'
			]
		]);
		
		$this->forge->addPrimaryKey('movie_id');
		$this->forge->createTable('movies');
	}

	public function down()
	{
		$this->forge->dropTable('movies');
	}
}
