<?php

namespace App;

use App\Events\CustomerCreated;
use App\Traits\CompanyScoped;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    use SpatialTrait;

    protected $dispatchesEvents = [
        'created' => CustomerCreated::class
    ];

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
        'receiving_hours',
        'adr_id'
    ];

    protected $spatialFields = [
        'location',
    ];

}
