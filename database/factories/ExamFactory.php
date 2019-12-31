<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Exam;
use Faker\Generator as Faker;

$factory->define(Exam::class, function (Faker $faker) {
    return [
        'amount' => $faker->randomNumber(),
        'finished_at' => $faker->date('d/m/Y'),
        'filters' => $faker->text(),
        'user_id' => factory(App\User::class),
    ];
});
