<?php

namespace Database\Factories;

use App\Models\BookCategories;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookCategoryFactory extends Factory
{
    protected $model = BookCategories::class;

    public function definition()
    {
        return [
            'categories_name' => $this->faker->unique()->regexify('[A-Za-z0-9]{10}'),
        ];
    }
}
