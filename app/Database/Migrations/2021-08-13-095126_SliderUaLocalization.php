<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SliderUaLocalization extends Migration
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
			]
		]);

		$this->forge->addPrimaryKey('slide_id');
		$this->forge->addForeignKey('slide_id', 'slides', 'slide_id');
		$this->forge->createTable('localization_uk_slides');
	}

	public function down()
	{
		$this->forge->dropTable('localization_uk_slides');
	}
}
