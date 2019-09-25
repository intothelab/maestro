<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Transporter;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Transporter::class, function (Faker $faker) {
    return [
        "code" => Str::random(10),
        "name" => $faker->name,
        "email" => $faker->email,
        "phone" => Str::random(10),
        "cnpj" =>$faker->name,
        "address" => $faker->name,
        "number" => $faker->name,
        "postal_code" => $faker->name,
        "state" => $faker->name,
        "city" => $faker->city,
        "latitude" => $faker->latitude,
        "longitude" => $faker->longitude
    ];
});
