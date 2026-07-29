<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoice';

    protected $fillable = [
        'idbooking',
        'nomor_invoice',
        'jenis',
        'nominal',
        'status',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'idbooking', 'idbooking');
    }
}
