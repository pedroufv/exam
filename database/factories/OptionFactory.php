<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Option;
use Faker\Generator as Faker;

$factory->define(Option::class, function (Faker $faker) {
    return [
        'statement' => $faker->text(),
        'correct' => $faker->text(),
        'question_id' => factory(App\Question::class),
    ];
});
