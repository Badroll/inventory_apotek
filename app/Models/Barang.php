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
        $sum = $this->transaksiItem()
                ->join('transaksi', 'transaksi_item.transaksi_id', '=', 'transaksi.id')
                ->selectRaw('SUM(CASE WHEN transaksi.jenis = "Pengadaan" THEN transaksi_item.jumlah ELSE -transaksi_item.jumlah END) as stok')
                ->value('stok');
        return $sum ? $sum : 0;
    }

}
