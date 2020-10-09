<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Faker\Provider\Quote as QuoteProvider;
use Faker\Factory as FakerFactory;

class QuoteFakerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Faker\Generator', function($app) {
            $faker = FakerFactory::create();
            $faker->addProvider(new QuoteProvider($faker));

            return $faker;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
