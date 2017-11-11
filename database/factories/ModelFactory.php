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

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'mobile' => $faker->phoneNumber,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'major_id' => function () {
            return factory(\App\Major::class)->create()->id;
        },
        'school_name' => function () {
            return factory(\App\School::class)->create()->name;
        },
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

$factory->define(App\School::class, function (Faker\Generator $faker) {
    $provinces = array_keys(\App\School::$provinces);
    return [
//        'name' => $faker->unique()->city . '大学',
        'name' => $faker->unique()->city,
        'province' => $provinces[rand(0, count($provinces) - 1)],
    ];
});

$factory->define(App\Major::class, function (Faker\Generator $faker) {
    return [
        'school_id' => function () {
            return factory(\App\School::class)->create()->id;
        },
        'name' => $faker->name . '工程',
        'department' => $faker->name . '学院',
    ];
});

$factory->define(App\Shuoshuo::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'major_id' => function () {
            return factory(\App\Major::class)->create()->id;
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
        'major_id' => function () {
            return factory(\App\Major::class)->create()->id;
        },
        'filename' => $faker->name . $suffix[rand(0, count($suffix) - 1)],
        'type' => $faker->numberBetween(0, 1),
        'category' => $faker->numberBetween(0, 1),
        'status' => $faker->numberBetween(0, 1),
        'downloads' => $faker->numberBetween(20, 100),
    ];
});
