<?php

use Illuminate\Database\Seeder;
use App\Models\Products;
use App\Models\ProductCategories;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 100 ; $i++) {
            $categoryArray = $faker->randomElements(['Category 1', 'Category 2', 'Category 3'], $faker->numberBetween(1, 3));
            $categoryString = implode(',', $categoryArray);
            
            $product = new Products([
                'name' => $faker->word,
                'description' => $faker->sentence,
                'price' => $faker->randomFloat(2, 1, 100),
                'category' => json_encode($categoryString),
            ]);
            
            $product->save();
        }

        $productCategories = new ProductCategories;
        $productCategories->category = 'Category 1';
        $productCategories->save();

        $productCategories = new ProductCategories;
        $productCategories->category = 'Category 2';
        $productCategories->save();

        $productCategories = new ProductCategories;
        $productCategories->category = 'Category 3';
        $productCategories->save();
    }
}