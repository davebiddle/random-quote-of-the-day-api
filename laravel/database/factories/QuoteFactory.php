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

            $author = Author::where('quotepark_id', $faker->authorQuoteparkId)->get()->first();

            if ($author instanceof Author) {
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
