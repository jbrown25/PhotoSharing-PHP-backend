<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class PhotosTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 1) as $index)
		{
			Photo::create([
				'user_id' => 1,
				'path' => 'img/image1.jpg',
				'caption' => 'caption 1.'
			]);

			Photo::create([
				'user_id' => 2,
				'path' => 'img/image2.jpg',
				'caption' => 'caption 2.'
			]);
		}
	}

}