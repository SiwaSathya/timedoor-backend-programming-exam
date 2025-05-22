<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\BookCategories;
use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition()
    {
        return [
            'book_name' => $this->faker->unique()->regexify('[A-Za-z0-9]{10}'),
            'author_id' => Author::inRandomOrder()->first()->id,
            'category_id' => BookCategories::inRandomOrder()->first()->id,
        ];
    }
}
