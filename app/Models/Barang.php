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
        'stok_minimum',
        'satuan',
        'expired',
    ];
    public $timestamps = false;

    public function kategori(){
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function transaksiItem(){
        return $this->hasMany(TransaksiItem::class);
    }

    public function getStok(){
        return $this->transaksiItem()->sum('jumlah');
    }

}
