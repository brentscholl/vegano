<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
    use Illuminate\Support\Carbon;

    $factory->define(App\Meal::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(4),
        'sub_title' => $faker->sentence(4),
        'description' => $faker->sentence(20),
        'time' => 30,
        'calories' => 300,
        'fat' => 22,
        'carbs' => 33,
        'protein' => 44,
        'servings' => 2,
        'image_id' => function () {
            return factory(App\Image::class)->create()->id;
        },
        'inventory' => 123,
        'sku' => $faker->ean13,
        'premium' => 0,
        'published' => 1,
        'start_date' => Carbon::now()->addDays(-3)->toDateString(),
        'end_date' => Carbon::now()->addMonth(3)->toDateString(),
    ];

});

$factory->define(App\Image::class, function (Faker $faker) {
    return [
        'imageable_type' => 'App\Meal',
        'imageable_id' => $faker->numberBetween(1, 20),
        'src' => '/images/uploads/',
        'extension' => '.png',
        'filename' => '1595018792_5f120e28eb678.png',
        'mime_type' => 'png',
        'file_size' => 1000
    ];
});
