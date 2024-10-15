<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert a pegawai user
        DB::table('users')->insert([
            'username' => 'pegawai',
            'name' => 'Pegawai User',
            'no_pegawai' => '12345',
            'jabatan' => 'Staff',
            'alamat' => 'Some Address',
            'active' => '1',
            'profile' => null,
            'role' => '1',
            'birthday' => '1990-01-01',
            'email' => 'pegawai@example.com',
            'password' => Hash::make('pegawai_user'), // Password same as username
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert an admin user
        DB::table('users')->insert([
            'username' => 'admin',
            'name' => 'Admin User',
            'no_pegawai' => '54321',
            'jabatan' => 'Administrator',
            'alamat' => 'Another Address',
            'active' => '1',
            'profile' => null,
            'role' => '0',
            'birthday' => '1985-05-05',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin_user'), // Password same as username
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
