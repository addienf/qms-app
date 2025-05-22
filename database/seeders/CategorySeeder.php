<?php

namespace Database\Seeders;

use App\Models\Inventory\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Category::insert([
            ['name' => 'Product Qlab'],
            ['name' => 'Product Non Qlab'],
        ]);
    }
}
