<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Subject;
use Faker\Generator as Faker;

$factory->define(Subject::class, function (Faker $faker) {
    return [
        'name' => $faker->text(),
        'description' => $faker->text(),
        'subcategory_id' => factory(App\Subcategory::class),
    ];
});
