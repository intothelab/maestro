<?php

namespace App;

use App\Traits\CompanyScoped;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    use SpatialTrait;

    protected $table = 'customers';

    protected $spatialFields = [
        'location',
    ];

}
