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
        'tglbooking',
        'idvilla',
        'idcustomer',
        'tglcekin',
        'tglcekout',
        'pic',
        'note',
        'harga',
        'total_harga'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'idcustomer');
    }

    public function villa()
    {
        return $this->belongsTo(Villa::class, 'idvilla');
    }
}
