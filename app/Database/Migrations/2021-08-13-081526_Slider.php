<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Slider extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'slide_id' => [
				'type' => 'INT',
				'auto_increment' => TRUE
			],
			'title' => [
				'type' => 'varchar(256)',
				'null' => TRUE,
			],
			'note' => [
				'type' => 'varchar(256)',
				'null' => TRUE,
			],
			'link' => [
				'type' => 'varchar(256)',
				'null' => TRUE,
			],
			'link_text' => [
				'type' => 'varchar(256)',
				'null' => TRUE,
			],
			'image' => [
				'type' => 'varchar(256)',
				'null' => TRUE,
			]
		]);

		$this->forge->addPrimaryKey('slide_id');
		$this->forge->createTable('slides');
	}

	public function down()
	{
		$this->forge->dropTable('slides');
	}
}
