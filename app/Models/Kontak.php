<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    protected $table = "kontak";
    protected $fillable = [
        'jenis',
        'nama',
        'keterangan',
    ];
    public $timestamps = false;
}
