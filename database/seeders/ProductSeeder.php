<?php

namespace Database\Seeders;

use App\Models\Inventory\Category;
use App\Models\Inventory\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $qlabCategoryId = Category::where('name', 'Product Qlab')->first()->id;
        $nonQlabCategoryId = Category::where('name', 'Product Non Qlab')->first()->id;

        $qlabProducts = [
            'QLab Walk-in Test Chamber',
            'Qlab Climatic Test Chamber',
            'Qlab Precision Refrigerator',
            'Qlab Monitoring System',
            'Other Qlab Product',
        ];

        foreach ($qlabProducts as $name) {
            Product::create([
                'product_name' => $name,
                'slug' => Str::slug($name),
                'category_id' => $qlabCategoryId,
            ]);
        }

        // Mecmesin → Product Non Qlab
        Product::create([
            'product_name' => 'Mecmesin',
            'slug' => Str::slug('Mecmesin'),
            'category_id' => $nonQlabCategoryId,
        ]);
    }
}
