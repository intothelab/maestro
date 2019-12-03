<?php

namespace App;

use App\Traits\CompanyScoped;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Transporter
 *
 * @property int $id
 * @property string|null $code
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $cnpj
 * @property string $address
 * @property string $number
 * @property string $postal_code
 * @property string $state
 * @property string $city
 * @property string|null $location
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Vehicle[] $vehicle
 * @property-read int|null $vehicle_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter comparison($geometryColumn, $geometry, $relationship)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter contains($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter crosses($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter disjoint($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter distance($geometryColumn, $geometry, $distance)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter distanceExcludingSelf($geometryColumn, $geometry, $distance)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter distanceSphere($geometryColumn, $geometry, $distance)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter distanceSphereExcludingSelf($geometryColumn, $geometry, $distance)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter distanceSphereValue($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter distanceValue($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter doesTouch($geometryColumn, $geometry)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter equals($geometryColumn, $geometry)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter intersects($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|\App\Transporter newModelQuery()
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|\App\Transporter newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Transporter onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter orderByDistance($geometryColumn, $geometry, $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter orderByDistanceSphere($geometryColumn, $geometry, $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter orderBySpatial($geometryColumn, $geometry, $orderFunction, $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter overlaps($geometryColumn, $geometry)
 * @method static \Grimzy\LaravelMysqlSpatial\Eloquent\Builder|\App\Transporter query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter whereCnpj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transporter withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transporter within($geometryColumn, $polygon)
 * @method static \Illuminate\Database\Query\Builder|\App\Transporter withoutTrashed()
 * @mixin \Eloquent
 */
class Transporter extends Model
{
    use SoftDeletes;
    use SpatialTrait;

    protected $table = 'transporters';
    protected $fillable = [
        'code',
        'name',
        'email',
        'phone',
        'address',
        'postal_code',
        'number'
    ];

    protected $spatialFields = [
        'location',
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function vehicle()
    {
        return $this->hasMany(Vehicle::class);
    }

}
