<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiItem extends Model
{
    protected $table = "transaksi_item";
    protected $fillable = [
        'transaksi_id',
        'barang_id',
        'harga',
        'jumlah',
    ];
    public $timestamps = false;

    public function transaksi(){
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    public function barang(){
        return $this->belongsTo(Barang::class, 'barang_id');
    }

}
