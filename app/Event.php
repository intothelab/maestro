<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Event
 *
 * @property int $id
 * @property int $document_id
 * @property string $edi_id
 * @property string $code
 * @property string $executed_at
 * @property string $received_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereDocumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereEdiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereExecutedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereReceivedAt($value)
 * @mixin \Eloquent
 */
class Event extends Model
{
    public $timestamps = false;

}
