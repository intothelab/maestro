<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Route
 *
 * @property int $id
 * @property string $code
 * @property string $mode
 * @property string $group
 * @property string $type
 * @property string $uf_origin
 * @property string $uf_destination
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Route newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Route newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Route query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Route whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Route whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Route whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Route whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Route whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Route whereMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Route whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Route whereUfDestination($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Route whereUfOrigin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Route whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Route extends Model
{
    //
}
