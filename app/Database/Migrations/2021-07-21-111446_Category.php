<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Category extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'category_id' => [
				'type' => 'INT',
				'auto_increment' => TRUE
			],
			'category_title' => [
				'type' => 'varchar(256)'
			]
		]);

		$this->forge->addPrimaryKey('category_id');

		$this->forge->createTable('categories');
		
		// $this->forge->addColumn('movies', [
		// 	'category_id' => [
		// 		'type' => 'INT'
		// 	],
		// 	'CONSTRAINT category_id_fk FOREIGN KEY(`category_id`) REFERENCES `categories`(`category_id`)'
		// ]);

		$this->forge->addField([
			'movie_category_id' => [
				'type' => 'INT',
				'auto_increment' => TRUE
			],
			'movie_id' => [
				'type' => 'INT'
			],
			'category_id' => [
				'type' => 'INT'
			]
		]);

		$this->forge->addPrimaryKey('movie_category_id');

		$this->forge->addForeignKey('movie_id', 'movies', 'movie_id');
		$this->forge->addForeignKey('category_id', 'categories', 'category_id');

		$this->forge->createTable('movie_category');
	}

	public function down()
	{
		// $this->forge->dropColumn('movies', 'category_id');
		$this->forge->dropTable('movie_category');
		$this->forge->dropTable('categories');
	}
}
