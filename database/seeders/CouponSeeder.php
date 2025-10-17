<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Coupon::create([
			'id' => 1,
			'code' => '10CONSULTINGOFF',
			'type' => 'price',
			'value' => 10,
			'expired_at' => NULL
		]);
	}
}
