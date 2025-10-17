<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run() {
        $this->call([
            RoleSeeder::class
        ]);
        $this->call([
            SuperAdminSeeder::class
        ]);
		$this->call([
			CountrySeeder::class
		]);
		$this->call([
			StateSeeder::class
		]);
		$this->call([
			ReviewQuestionSeeder::class
		]);
		$this->call([
			CategorySeeder::class
		]);
		$this->call([
			CouponSeeder::class
		]);
	}
}
