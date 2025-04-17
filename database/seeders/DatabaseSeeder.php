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
            'username' => 'project manager',
            'name' => 'PM',
            'no_pegawai' => '1',
            'jabatan' => 'project manager',
            'alamat' => 'Tasikmalaya',
            'active' => '1',
            'profile' => null,
            'role' => '0',
            'birthday' => '1990-01-01',
            'email' => 'pm@example.com',
            'password' => Hash::make('12345'), // Password same as username
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert an admin user
        DB::table('users')->insert([
            'username' => 'Team lead',
            'name' => 'team lead',
            'no_pegawai' => '2',
            'jabatan' => 'pemimpin team',
            'alamat' => 'purwakarta',
            'active' => '1',
            'profile' => null,
            'role' => '1',
            'birthday' => '1985-05-05',
            'email' => 'teamlead@example.com',
            'password' => Hash::make('12345'), // Password same as username
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'username' => 'finance',
            'name' => 'finance',
            'no_pegawai' => '3',
            'jabatan' => 'keuangan',
            'alamat' => 'purwakarta',
            'active' => '1',
            'profile' => null,
            'role' => '2',
            'birthday' => '1985-05-05',
            'email' => 'finance@example.com',
            'password' => Hash::make('12345'), // Password same as username
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
