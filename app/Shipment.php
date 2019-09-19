<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use \CompanyScoped;

    protected $table = 'shipments';
}
