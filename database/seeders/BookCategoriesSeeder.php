<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BookCategories;
use Faker\Factory as Faker;

class BookCategoriesSeeder extends Seeder
{
    public function run()
    {
        set_time_limit(1000);
        ini_set('memory_limit', '2G');

        $faker = Faker::create();
        $categories = [];

        for ($i = 0; $i < 3000; $i++) {
            $categories[] = [
                'categories_name' => $faker->unique()->regexify('[A-Za-z0-9]{10}'),
            ];

            if (count($categories) >= 1000) {
                BookCategories::insert($categories);
                $categories = [];
            }
        }

        if (count($categories) > 0) {
            BookCategories::insert($categories);
        }
    }
}

