<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class XML extends BaseController
{
	public function index()
	{
		echo 321;
	}

	public function gen_database()
	{
		// echo 123;
		// var_dump();
		$xml = simplexml_load_file(ROOTPATH.'app/Controllers/movies.xml');

		// var_dump($xml);

		foreach($xml->object as $object)
		{
			var_dump($object);
			// $attr = 'attributes';
			$title = $object['title'];
			$mgg_id = $object['id'];
			$title = $object['title'];
			// var_dump($attributes);
		}
	}
}
