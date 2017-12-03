<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;
    static $forumIds = [
        48,
        54,
        55,
        56,
        58,
        59,
        60,
        61,
        62,
        63,
        64,
        65,
        66,
        67,
        68,
        69,
        70,
        71,
        72,
        73,
        74,
        75,
        76,
        77,
        78,
        89
    ];

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'mobile' => $faker->phoneNumber,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'forum_id' => $forumIds[rand(0, count($forumIds) - 1)]
    ];
});

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(6, true),
        'content' => $faker->text(500),
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        }
    ];
});


$factory->define(App\Forum::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});

$factory->define(App\Shuoshuo::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'forum_id' => function () {
            return factory(\App\Forum::class)->create()->id;
        },
        'content' => $faker->sentence(50, true),
    ];
});

$factory->define(App\ShuoshuoComment::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'shuoshuo_id' => function () {
            return factory(\App\Shuoshuo::class)->create()->id;
        },
        'content' => $faker->sentence(10, true),
    ];
});


$factory->define(App\File::class, function (Faker\Generator $faker) {
    $suffix = \App\File::$suffix;
    return [
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'forum_id' => function () {
            return factory(\App\Forum::class)->create()->id;
        },
        'filename' => $faker->name . $suffix[rand(0, count($suffix) - 1)],
        'type' => $faker->numberBetween(0, 1),
        'category' => $faker->numberBetween(0, 1),
        'status' => $faker->numberBetween(0, 1),
        'downloads' => $faker->numberBetween(20, 100),
    ];
});
