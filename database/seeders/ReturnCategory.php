<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ReturnCategory as Category;

class ReturnCategory extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'category_name' => 'Damage Product'
            ],
            [
                'category_name' => 'Incorrect order'
            ],
            [
                'category_name' => 'Out Of Stock'
            ],
            [
                'category_name' => 'Others'
            ],
        ];

        Category::insert($data);
    }
}
