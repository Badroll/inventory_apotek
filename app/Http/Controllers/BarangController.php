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
        // $barang = DB::select("
        //     SELECT A.*, B.nama as kategori_nama FROM barang as A
        //     JOIN kategori as B ON A.kategori_id = B.id
        // ", []);
        $barang = Barang::all();

        $data["barang"] = $barang;
        return view("barang.index", $data);
    }


    public function create(Request $request){
        $kategori_id = $request->{"kategori_id"};
        $nama = $request->{"nama"};
        $keterangan = $request->{"keterangan"};
        $stok_minimum = $request->{"stok_minimum"};
        $satuan = $request->{"satuan"};
        $expired = $request->{"expired"};
        if(!$kategori_id) return redirect(url("barang"))->with("error", "Parameter tidak lengkap (kategori_id)");
        if(!$nama) return redirect(url("barang"))->with("error", "Parameter tidak lengkap (nama)");
        if(!$keterangan) return redirect(url("barang"))->with("error", "Parameter tidak lengkap (keterangan)");
        if(!$stok_minimum) return redirect(url("barang"))->with("error", "Parameter tidak lengkap (stok_minimum)");
        if(!$satuan) return redirect(url("barang"))->with("error", "Parameter tidak lengkap (satuan)");
        if(!$expired) return redirect(url("barang"))->with("error", "Parameter tidak lengkap (expired)");

        $barang = new Barang;
        $barang->kategori_id = $kategori_id;
        $barang->nama = $nama;
        $barang->keterangan = $keterangan;
        $barang->stok_minimum = $stok_minimum;
        $barang->satuan = $satuan;
        $barang->expired = $expired;
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
        $keterangan = $request->{"keterangan"};
        $stok_minimum = $request->{"stok_minimum"};
        $satuan = $request->{"satuan"};
        $expired = $request->{"expired"};
        if(!$id) return redirect(url("barang"))->with("error", "Parameter tidak lengkap (id)");
        if(!$kategori_id) return redirect(url("barang"))->with("error", "Parameter tidak lengkap (kategori_id)");
        if(!$nama) return redirect(url("barang"))->with("error", "Parameter tidak lengkap (nama)");
        if(!$keterangan) return redirect(url("barang"))->with("error", "Parameter tidak lengkap (keterangan)");
        if(!$stok_minimum) return redirect(url("barang"))->with("error", "Parameter tidak lengkap (stok_minimum)");
        if(!$satuan) return redirect(url("barang"))->with("error", "Parameter tidak lengkap (satuan)");
        if(!$expired) return redirect(url("barang"))->with("error", "Parameter tidak lengkap (expired)");

        $barang = Barang::find($id);
        if(!$barang){
            return redirect(url("barang"))->with("error", "Barang tidak ditemukan");
        }
        $barang->kategori_id = $kategori_id;
        $barang->nama = $nama;
        $barang->keterangan = $keterangan;
        $barang->stok_minimum = $stok_minimum;
        $barang->satuan = $satuan;
        $barang->expired = $expired;
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
