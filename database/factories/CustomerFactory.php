<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Support\Str;

$factory->define(\App\Customer::class, function (Faker $faker) {
    return [
        "code" => Str::random(6),
        "name" => $faker->company,
        "email" => $faker->email,
        "phone" => $faker->phoneNumber,
        "cnpj" => $faker->numerify('###############'),
        "address" => $faker->streetName,
        "number" => $faker->buildingNumber,
        "postal_code" => $faker->numerify('########'),
        "state" => $faker->randomElement(['MG','RS', 'SP', 'RJ', 'BA', 'PR']),
        "city" => $faker->city,
        "location" => new Point(
            $faker->latitude,
            $faker->longitude
        )
    ];
});
