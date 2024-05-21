<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = "transaksi";
    protected $fillable = [
        'kode',
        'jenis',
        'tanggal',
        'mitra_id',
        'keterangan',
    ];
    public $timestamps = false;

    public function transaksiItem(){
        return $this->hasMany(TransaksiItem::class);
    }

    public function mitra(){
        return $this->belongsTo(Kontak::class, 'mitra_id');
    }

    public function getTotalHarga(){
        return $this->transaksiItem()->sum(\DB::raw('jumlah * harga'));
    }

}
