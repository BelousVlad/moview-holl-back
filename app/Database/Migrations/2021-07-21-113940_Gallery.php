<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Gallery extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'gallery_id' => [
				'type' => 'INT',
				'auto_increment' => TRUE
			],
			'movie_id' => [
				'type' => 'INT'
			],
			'gallery_img' => [
				'type' => 'varchar(256)'
			]
		]);

		$this->forge->addPrimaryKey('gallery_id');

		$this->forge->addForeignKey('movie_id', 'movies', 'movie_id');

		$this->forge->createTable('gallery');
	}

	public function down()
	{
		$this->forge->dropTable('gallery');
	}
}
