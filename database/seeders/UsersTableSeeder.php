<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user = Role::firstOrCreate(['name' => 'user']);


        $adminUser = User::firstOrCreate(
            [   'email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password')
            ]
        );

        $adminUser->assignRole('admin');
    }
}
