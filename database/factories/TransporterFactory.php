<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Transporter;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Transporter::class, function (Faker $faker) {
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
        "location" => new \Grimzy\LaravelMysqlSpatial\Types\Point(
            $faker->latitude,
            $faker->longitude
        )
    ];
});
