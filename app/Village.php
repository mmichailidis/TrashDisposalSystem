<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 *
 * @property mixed id
 * @property mixed name
 * @property mixed type
 * @property mixed latitude
 * @property mixed longitude
 */
class Village extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'villages';

    protected $fillable = [
        'name',
        'type',
        'latitude',
        'longitude'
    ];

    protected $guarded = [
        'id'
    ];
}
