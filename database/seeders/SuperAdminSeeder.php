<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::updateOrCreate(['name' => Config::get('constants.users_roles.super_admin')]);

        $user = User::updateOrCreate([
            'email' => 'admin@123consulting.com'
        ], [
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'password' => Hash::make('123@consulting#2023'),
            'status' => 1,
			'is_password_sent' => 1,
		]);

        $user->markEmailAsVerified();

        $user->assignRole($role);
    }
}
