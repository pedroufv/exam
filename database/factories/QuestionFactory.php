<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'statement' => $faker->text(),
        'subject_id' => factory(App\Subject::class),
        'user_id' => factory(App\User::class),
        'contest_id' => factory(App\Contest::class),
    ];
});
