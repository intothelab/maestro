<?php

namespace App;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    use SpatialTrait;

    protected $table = 'companies';

    protected $spatialFields = [
        'location',
    ];

}
