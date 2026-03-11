<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';

    protected $primaryKey = 'idcustomer';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'idcustomer',
        'nama_customer',
        'alamat_customer',
        'notelp_customer'
    ];

    
}
