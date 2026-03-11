<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Villa extends Model
{
    // use HasFactory;
    protected $table = 'villa';

    protected $primaryKey = 'idvilla';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'idvilla',
        'nama_villa',
        'alamat_villa'
    ];
}
