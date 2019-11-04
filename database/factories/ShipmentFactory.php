<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Shipment;
use App\Transporter;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Shipment::class, function (Faker $faker) {
    return [
        "transporter_cnpj" => function(){
            return factory(Transporter::class)
                ->create()
                ->cnpj;
        },
        "code" => Str::random(15),
        "invoice" => Str::random(5),
        "weight" => $faker->randomFloat(2, 1500, 4500),
        "value" => $faker->randomFloat(2, 1000, 9999),
        "description" => $faker->text(30)
    ];
});
