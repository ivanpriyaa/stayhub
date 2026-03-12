<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';

    protected $primaryKey = 'idbooking';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'idbooking',
        'idvilla',
        'idcustomer',
        'tglbooking',
        'pic',
        'tglcekin',
        'tglcekout',
        'tglcekout'
    ];
}
