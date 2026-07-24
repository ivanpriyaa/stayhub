<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoice'; // ubah menjadi 'invoices' jika nama tabel Anda jamak

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
