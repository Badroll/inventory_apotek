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
            SELECT A.*, B.nama as barang_nama, C.nama as kategori_nama
            FROM transaksi as A
            JOIN barang as B ON A.barang_id = B.id
            JOIN kategori as C ON B.kategori_id = C.id
            WHERE 0 = 0
        ";
        if($periode == "d"){
            $qry .= " AND DATE(a.tanggal) = '". date("Y-m-d") ."' ";
        }
        else if($periode == "m"){
            $qry .= " AND YEAR(a.tanggal) = '". date("Y") ."' AND MONTH(a.tanggal) = '". (intval(date("m"))) ."' ";
        }
        else if($periode == "y"){
            $qry .= " AND YEAR(a.tanggal) = '". date("Y") ."' ";
        }
        //dd($qry);

        $cashflow = DB::select($qry, []);
        $data["cashflow"] = $cashflow;
        $data["periode"] = $periode;
        return view("cashflow.index", $data);
    }


}
