<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Order::class, function (Faker $faker) {
    return [
        'company_cnpj' => $faker->numerify('##############'),
        'customer_cnpj' => $faker->numerify('##############'),
        'code' => $faker->numerify('######'),
        'value' => $faker->randomFloat(2),
        'weight' => $faker->randomFloat(2)
    ];
});
