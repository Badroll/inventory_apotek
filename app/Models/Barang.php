<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = "barang";
    protected $fillable = [
        'kategori_id',
        'nama',
        'keterangan',
        'stok',
    ];
    public $timestamps = false;
}
