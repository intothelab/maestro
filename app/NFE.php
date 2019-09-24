<?php
namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Moloquent;

class NFE extends Moloquent {
    protected $connection = 'mongodb';
    protected $collection = 'nfe';
}