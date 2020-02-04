<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ReadingList;
use App\Book;
use App\User;
use Faker\Generator as Faker;

$factory->define(ReadingList::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'user_id' => User::all()->random()->id
    ];
});

$factory->afterCreating(ReadingList::class, function (ReadingList $readingList) {
    $readingList->books()->sync(Book::all()->random(rand(1, 12)));
});
