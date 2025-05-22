<?php
namespace App\Providers;

use App\Models\Rates;
use Illuminate\Support\ServiceProvider;
use App\Repositories\BookRepository;
use App\Repositories\BookCategoriesRepository;
use App\Repositories\AuthorRepository;
use App\Repositories\RatesRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Menyuntikkan repository ke dalam container
        $this->app->bind(BookRepository::class, function ($app) {
            return new BookRepository();
        });

        $this->app->bind(BookCategoriesRepository::class, function ($app) {
            return new BookCategoriesRepository();
        });

        $this->app->bind(AuthorRepository::class, function ($app) {
            return new AuthorRepository();
        });

        $this->app->bind(RatesRepository::class, function ($app) {
            return new RatesRepository();
        });
    }

    public function boot()
    {
        //
    }
}
