<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pic extends Model
{
    protected $table = 'pic';

    protected $primaryKey = 'idpic';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'idpic',
        'pic',
        'nama_agen',
    ];
}
