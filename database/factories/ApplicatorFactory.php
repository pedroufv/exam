<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Applicator;
use Faker\Generator as Faker;

$factory->define(Applicator::class, function (Faker $faker) {
    return [
        'name' => $faker->text(),
        'acronym' => $faker->text(10),
    ];
});
