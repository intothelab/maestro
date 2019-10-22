<?php

namespace App;

use App\Traits\CompanyScoped;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    use SpatialTrait;

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'zip',
        'address',
        'number',
        'postal_code',
        'city',
        'state',
        'location',
        'extra_tax',
        'receiving_days',
        'receiving_hours'
    ];

    protected $spatialFields = [
        'location',
    ];

}
