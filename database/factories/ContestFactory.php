<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Contest;
use Faker\Generator as Faker;

$factory->define(Contest::class, function (Faker $faker) {
    return [
        'name' => $faker->text(),
        'year' => $faker->text(4),
        'number' => $faker->randomNumber(),
        'institution_id' => factory(App\Institution::class),
        'applicator_id' => factory(App\Applicator::class),
    ];
});
