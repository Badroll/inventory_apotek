<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use Session, DB;

class BarangController extends Controller
{
    public function __construct(){
    }


    public function index(Request $request){
        $barang = DB::select("
            SELECT A.*, B.nama as kategori_nama FROM barang as A
            JOIN kategori as B ON A.kategori_id = B.id
        ", []);

        $data["barang"] = $barang;
        return view("barang.index", $data);
    }


    public function create(Request $request){
        $kategori_id = $request->{"kategori_id"};
        $nama = $request->{"nama"};
        //$harga = $request->{"harga"};
        $keterangan = $request->{"keterangan"};
        if(!$kategori_id) return redirect(url("barang"))->with("error", "Parameter tidak lengkap (kategori_id)");
        if(!$nama) return redirect(url("barang"))->with("error", "Parameter tidak lengkap (nama)");
        //if(!$harga) return redirect(url("barang"))->with("error", "Parameter tidak lengkap (harga)");
        if(!$keterangan) return redirect(url("barang"))->with("error", "Parameter tidak lengkap (keterangan)");

        $barang = new Barang;
        $barang->kategori_id = $kategori_id;
        $barang->nama = $nama;
        //$barang->harga = $harga;
        $barang->keterangan = $keterangan;
        $barang->save();
        
        return redirect(url("barang"))->with("success", "Barang berhasil disimpan");
    }


    public function form(Request $request){
        $ref_kategori = Kategori::all();
        $data["ref_kategori"] = $ref_kategori;

        $id = $request->{"id"};
        if(!$id){
            return view("barang.form", $data);
        }

        $lastData = Barang::find($id);
        if(!$lastData){
            return redirect(url("barang"))->with("error", "Barang tidak ditemukan");
        }

        $data["barang"] = $lastData;
        return view("barang.form", $data);
    }


    public function update(Request $request){
        $id = $request->{"id"};
        $kategori_id = $request->{"kategori_id"};
        $nama = $request->{"nama"};
        //$harga = $request->{"harga"};
        $keterangan = $request->{"keterangan"};
        if(!$id) return redirect(url("barang"))->with("error", "Parameter tidak lengkap (id)");
        if(!$kategori_id) return redirect(url("barang"))->with("error", "Parameter tidak lengkap (kategori_id)");
        if(!$nama) return redirect(url("barang"))->with("error", "Parameter tidak lengkap (nama)");
        //if(!$harga) return redirect(url("barang"))->with("error", "Parameter tidak lengkap (harga)");
        if(!$keterangan) return redirect(url("barang"))->with("error", "Parameter tidak lengkap (keterangan)");

        $barang = Barang::find($id);
        if(!$barang){
            return redirect(url("barang"))->with("error", "Barang tidak ditemukan");
        }
        $barang->kategori_id = $kategori_id;
        $barang->nama = $nama;
        //$barang->harga = $harga;
        $barang->keterangan = $keterangan;
        $barang->save();
        
        return redirect(url("barang"))->with("success", "Barang berhasil diperbarui");
    }


    public function delete(Request $request){
        $id = $request->{"id"};
        if(!$id){
            return redirect(url("barang"))->with("error", "Inputan tidak valid");
        }

        $lastData = Barang::find($id);
        if(count($lastData->get()) == 0){
            return redirect(url("barang"))->with("error", "Barang tidak ditemukan");
        }

        $lastData->delete();

        return redirect(url("barang"))->with("success", "Barang berhasil dihapus");
    }

}
