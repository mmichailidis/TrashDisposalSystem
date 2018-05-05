<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 *
 * @property mixed id
 * @property mixed name
 * @property mixed type
 */
class Village extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'village';

    protected $fillable = [
        'name',
        'type'
    ];

    protected $guarded = [
        'id'
    ];
}
