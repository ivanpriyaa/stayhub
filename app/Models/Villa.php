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
        'alamat_villa',
        'harga_villa',
        'jumlah_kamar_tidur',
        'deskripsi_villa',
        'gambar_villa',
    ];
    public function booking()
    {
        return $this->hasMany(Booking::class, 'idvilla');
    }

    public function images()
    {
        return $this->hasMany(VillaImage::class, 'villa_id', 'idvilla');
    }

    public function mainImage()
    {
        return $this->hasOne(VillaImage::class, 'villa_id', 'idvilla')->oldest();
    }
}
