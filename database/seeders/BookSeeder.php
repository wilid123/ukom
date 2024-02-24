<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->insert([
            'book_code' => 'A0-001',
            'title' => 'hujan',
            'cover' => '',
            'slug' => 'hujan',
            'writer' => 'wildannn',
            'publisher' => 'idan',
            'year_publish' => '2022',
            'status' => 'in stock',
            'stock' => '1',
        ]);
        DB::table('books')->insert([
            'book_code' => 'A0-002',
            'title' => 'meteor',
            'cover' => '',
            'slug' => 'meteor',
            'writer' => 'wildannn',
            'publisher' => 'idan',
            'year_publish' => '2022',
            'status' => 'in stock',
            'stock' => '1',
        ]);
        DB::table('books')->insert([
            'book_code' => 'A0-003',
            'title' => 'tornado',
            'cover' => '',
            'slug' => 'tornado',
            'writer' => 'wildannn',
            'publisher' => 'idan',
            'year_publish' => '2022',
            'status' => 'in stock',
            'stock' => '1',
        ]);
    }
}
