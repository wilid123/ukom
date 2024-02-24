<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        DB::table('users')->insert([
            'username' => 'admin',
            'slug' => 'admin',
            'password' => '$2y$10$0yrjPcQoY9f0TkvXLwB8Des.ESmvsGJrQCVrk9ptrB8TAXxuhhfM6',
            'phone' => '083812334555',
            'address' => 'alamak',
            'status' => 'active',
            'role_id' => '1',
        ]);

        DB::table('users')->insert([
            'username' => 'petugas',
            'slug' => 'petugas',
            'password' => '$2y$10$0yrjPcQoY9f0TkvXLwB8Des.ESmvsGJrQCVrk9ptrB8TAXxuhhfM6',
            'phone' => '083812334555',
            'address' => 'alamak',
            'status' => 'active',
            'role_id' => '3',
        ]);

        DB::table('users')->insert([
            'username' => 'wildan',
            'slug' => 'wildan',
            'password' => '$2y$10$0yrjPcQoY9f0TkvXLwB8Des.ESmvsGJrQCVrk9ptrB8TAXxuhhfM6',
            'phone' => '083812334555',
            'address' => 'alamak',
            'status' => 'active',
            'role_id' => '2',
        ]);

        DB::table('users')->insert([
            'username' => 'deni',
            'slug' => 'deni',
            'password' => '$2y$10$0yrjPcQoY9f0TkvXLwB8Des.ESmvsGJrQCVrk9ptrB8TAXxuhhfM6',
            'phone' => '89287',
            'address' => 'rumah',
            'status' => 'active',
            'role_id' => '2',
        ]);
    }
}
