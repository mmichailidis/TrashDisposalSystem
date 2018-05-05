<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 *
 * @property mixed id
 * @property mixed route_village
 * @property mixed connected_village
 */
class VillageConnection extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'connections';

    protected $fillable = [
        'route_village',
        'connected_village'
    ];

    protected $guarded = [
        'id'
    ];
}
