<?php

namespace App;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Supplier
 *
 * @property int $id
 * @property string $name
 * @property string|null $code
 * @property string $cnpj
 * @property string $email
 * @property string $phone
 * @property string|null $contact_name
 * @property string|null $contact_phone
 * @property string|null $description
 * @property string $address
 * @property string $number
 * @property string $postal_code
 * @property string $state
 * @property string $city
 * @property string|null $location
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier comparison($geometryColumn, $geometry, $relationship)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier contains($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier crosses($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier disjoint($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier distance($geometryColumn, $geometry, $distance)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier distanceExcludingSelf($geometryColumn, $geometry, $distance)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier distanceSphere($geometryColumn, $geometry, $distance)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier distanceSphereExcludingSelf($geometryColumn, $geometry, $distance)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier distanceSphereValue($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier distanceValue($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier doesTouch($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier equals($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier intersects($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|\App\Supplier newModelQuery()
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|\App\Supplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier orderByDistance($geometryColumn, $geometry, $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier orderByDistanceSphere($geometryColumn, $geometry, $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier orderBySpatial($geometryColumn, $geometry, $orderFunction, $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier overlaps($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|\App\Supplier query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier whereCnpj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier whereContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier whereContactPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Supplier within($geometryColumn, $polygon)
 * @mixin \Eloquent
 */
class Supplier extends Model
{
    use SpatialTrait;

    protected $fillable = ['name', 'cnpj', 'email', 'phone', 'contact_name', 'contact_phone', 'description', 'location', 'zipcode', 'address'];

    protected $spatialFields = [
        'location',
    ];
}
