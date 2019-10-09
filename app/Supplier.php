<?php

namespace App;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use SpatialTrait;

    protected $fillable = ['name', 'cnpj', 'email', 'phone', 'contact_name', 'contact_phone', 'description', 'location', 'zipcode', 'address'];

    protected $spatialFields = [
        'location',
    ];
}
