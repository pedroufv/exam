<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Contest;
use Faker\Generator as Faker;

$factory->define(Contest::class, function (Faker $faker) {
    return [
        'name' => $faker->text(),
        'year' => $faker->numberBetween(2000, 2019),
        'number' => $faker->randomNumber(),
        'institution_id' => factory(App\Institution::class),
        'applicator_id' => factory(App\Applicator::class),
    ];
});
