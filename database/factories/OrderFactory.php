<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Order::class, function (Faker $faker) {
    return [
        'company_cnpj' => function() {
            return factory(\App\Company::class)->create()->cnpj;
        },
        'customer_cnpj' => function() {
            return factory(\App\Customer::class)->create()->cnpj;
        },
        'code' => $faker->numerify('######'),
        'value' => $faker->randomFloat(2, 100, 10000),
        'weight' => $faker->randomFloat(2, 100, 10000)
    ];
});
