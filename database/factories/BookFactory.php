<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'title' => implode(' ', $faker->words($faker->numberBetween(1, 5))),
        'isbn' => $faker->unique()->randomNumber(9)
    ];
});
