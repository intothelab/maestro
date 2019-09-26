<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use App\Model;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Company::class, function (Faker $faker) {
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
        "latitude" => $faker->latitude,
        "longitude" => $faker->longitude
    ];
});
