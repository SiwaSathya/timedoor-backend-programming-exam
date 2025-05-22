<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Author;
use App\Models\BookCategories;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    public function run()
    {

        set_time_limit(1000);
        ini_set('memory_limit', '2G');


        DB::statement('SET FOREIGN_KEY_CHECKS=0;');


        Book::withoutEvents(function () {
            Book::withoutTimestamps(function () {
                $faker = Faker::create();
                $chunkSize = 300;
                $createdBooks = 0;
                $totalBooks = 120000;


                $authors = Author::all()->pluck('id')->toArray();
                $categories = BookCategories::all()->pluck('id')->toArray();


                shuffle($authors);
                shuffle($categories);


                while ($createdBooks < $totalBooks) {

                    Author::chunk($chunkSize, function ($authors) use ($faker, $chunkSize, $totalBooks, &$createdBooks, $categories) {

                        BookCategories::chunk($chunkSize, function ($categories) use ($faker, $authors, $chunkSize, $totalBooks, &$createdBooks) {
                            $books = [];


                            foreach ($authors as $author) {
                                foreach ($categories as $category) {
                                    if ($createdBooks < $totalBooks) {
                                        $books[] = [
                                            'book_name' => $faker->unique()->sentence(),
                                            'author_id' => $author->id,
                                            'category_id' => $category->id,
                                            'created_at' => now(),
                                            'updated_at' => now(),
                                        ];
                                        $createdBooks++;


                                        if (count($books) >= $chunkSize) {
                                            Book::insert($books);
                                            $books = [];
                                        }
                                    }
                                }
                            }


                            if (count($books) > 0) {
                                Book::insert($books);
                            }


                            if ($createdBooks >= $totalBooks) {
                                return false;
                            }
                        });
                    });
                }
            });
        });


        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
