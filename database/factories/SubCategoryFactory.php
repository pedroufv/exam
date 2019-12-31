<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SubCategory;
use Faker\Generator as Faker;

$factory->define(SubCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->text(),
        'description' => $faker->text(),
        'category_id' => factory(App\Category::class),
    ];
});
