<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    public function run()
    {

        set_time_limit(1000);
        ini_set('memory_limit', '2G');

        $faker = Faker::create();
        $authors = [];

        for ($i = 0; $i < 1000; $i++) {
            $authors[] = [
               'name' => $faker->unique()->regexify('[A-Za-z0-9]{10}'),
            ];


            if (count($authors) >= 1000) {
                Author::insert($authors);
                $authors = [];
            }
        }


        if (count($authors) > 0) {
            Author::insert($authors);
        }
    }
}
