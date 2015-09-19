<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();
		$faker = Faker::create();

		foreach(range(1, 1) as $index)
		{
			User::create([
				'username' => 'username1',
				'password' => Hash::make('password')
			]);

			User::create([
				'username' => 'username2',
				'password' => Hash::make('password')
			]);
		}
	}

}