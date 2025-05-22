<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rates;
use App\Models\Book;
use App\Models\Author;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class RatesSeeder extends Seeder
{
    public function run()
    {

        set_time_limit(1000);
        ini_set('memory_limit', '2G');


        $totalRates = 502000;


        DB::statement('SET FOREIGN_KEY_CHECKS=0;');


        Rates::withoutEvents(function () use ($totalRates) {
            Rates::withoutTimestamps(function () use ($totalRates) {
                $faker = Faker::create();
                $chunkSize = 500;
                $createdRates = 0;


                while ($createdRates < $totalRates) {


                    Book::chunk($chunkSize, function ($books) use ($faker, $chunkSize, $totalRates, &$createdRates) {
                        $rates = [];


                        foreach ($books as $book) {

                            $authorId = $book->author_id;


                            if ($createdRates < $totalRates) {
                                $rates[] = [
                                    'rating' => $faker->numberBetween(1, 10),
                                    'book_id' => $book->id,
                                    'author_id' => $authorId,
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ];
                                $createdRates++;


                                if (count($rates) >= $chunkSize) {
                                    Rates::insert($rates);
                                    $rates = [];
                                }
                            }
                        }


                        if (count($rates) > 0) {
                            Rates::insert($rates);
                        }
                    });
                }
            });
        });


        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

