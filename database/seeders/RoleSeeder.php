<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$roles = Config::get('constants.users_roles');
		foreach ($roles as $role) {
			$role = Role::updateOrCreate(['name' => $role]);
		}
	}
}
