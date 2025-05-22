<?php

namespace Database\Factories;

use App\Models\Rates;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class RateFactory extends Factory
{
    protected $model = Rates::class;

    public function definition()
    {
        return [
            'rating' => $this->faker->numberBetween(1, 10),
            'book_id' => Book::inRandomOrder()->first()->id,
            'author_id' => Author::inRandomOrder()->first()->id,
        ];
    }
}
