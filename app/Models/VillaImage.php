<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VillaImage extends Model
{
    protected $table = 'villa_images';
    protected $fillable = ['villa_id', 'gambar'];

    public function villa()
    {
        return $this->belongsTo(Villa::class, 'villa_id');
    }
}
