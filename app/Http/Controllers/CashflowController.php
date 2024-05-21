<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session, DB;

class CashflowController extends Controller
{
    public function __construct(Request $request){
    }

    public function index(Request $request){
        $periode = $request->{"periode"};
        $qry = "
            SELECT X.harga, X.jumlah, A.jenis, A.kode, A.tanggal, B.nama as barang_nama, C.nama as kategori_nama
            FROM transaksi_item as X
            JOIN transaksi as A ON A.id = X.transaksi_id
            JOIN barang as B ON X.barang_id = B.id
            JOIN kategori as C ON B.kategori_id = C.id
        ";
        if($periode == "d"){
            $qry .= " AND DATE(a.tanggal) = '". date("Y-m-d") ."' ";
        }
        else if($periode == "m"){
            $qry .= " AND MONTH(a.tanggal) = '". date("Y-m") ."' ";
        }
        else if($periode == "y"){
            $qry .= " AND YEAR(a.tanggal) = '". date("Y") ."' ";
        }

        $cashflow = DB::select($qry, []);
        $data["cashflow"] = $cashflow;
        $data["periode"] = $periode;
        return view("cashflow.index", $data);
    }


}
