<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Quote;
use App\Author;

$factory->define(Quote::class, function (Faker\Generator $faker) {

    $faker->setCurrentQuote();

    return [
        'quotepark_id' => $faker->quoteparkId,
        'content' => $faker->content,
        'link' => $faker->link,
        'author_id' => function (array $quote) use ($faker) {

            $authorExists = Author::where('quotepark_id', $faker->authorQuoteparkId)->count();

            if ($authorExists) {
                return $author->id;
            }

            return factory(Author::class)->create([
                'quotepark_id' => $faker->authorQuoteparkId,
                'name' => $faker->authorName,
                'link' => $faker->authorLink,
            ])->id;
        },
    ];
});
