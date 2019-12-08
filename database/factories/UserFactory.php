<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentences,
        'content' => $faker->sentences,
        'image' => 'photo1.png',
        'date' => '07/09/19',
        'views' => $faker->numberBetween(1, 1000),
        'category_id' => 3,
        'user_id' => 1,
        'status' => 1,
        'is_featured' => 0,

    ];
});

$factory->define(\App\Category::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
    ];
});

$factory->define(\App\Tag::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
    ];
});
