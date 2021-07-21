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
		
		$this->forge->addColumn('movies', [
			'category_id' => [
				'type' => 'INT'
			],
			'CONSTRAINT category_id_fk FOREIGN KEY(`category_id`) REFERENCES `categories`(`category_id`)'
		]);
	}

	public function down()
	{
		$this->forge->dropColumn('movies', 'category_id');
		$this->forge->dropTable('categories');
	}
}
