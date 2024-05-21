<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kontak;
use Session;

class KontakController extends Controller
{
    public function __construct(){
    }


    public function index(Request $request){
        $kontak = Kontak::all();

        $data["kontak"] = $kontak;
        return view("kontak.index", $data);
    }


    public function create(Request $request){
        $jenis = $request->{"jenis"};
        $nama = $request->{"nama"};
        $keterangan = $request->{"keterangan"};
        if(!$jenis){
            return redirect(url("kontak"))->with("error", "Parameter incomplete (jenis)");
        }
        if(!$nama){
            return redirect(url("kontak"))->with("error", "Parameter incomplete (nama)");
        }
        if(!$keterangan){
            return redirect(url("kontak"))->with("error", "Parameter incomplete (keterangan)");
        }
        $kontak = new Kontak;
        $kontak->jenis = $jenis;
        $kontak->nama = $nama;
        $kontak->keterangan = $keterangan;
        $kontak->save();

        return redirect(url("kontak"))->with("success", "Kontak berhasil disimpan");
    }


    public function form(Request $request){
        $id = $request->{"id"};
        if(!$id){
            return view("kontak.form");
        }

        $lastData = Kontak::find($id);
        if(!$lastData){
            return redirect(url("kontak"))->with("error", "Kontak tidak ditemukan");
        }

        $data["kontak"] = $lastData;
        return view("kontak.form", $data);
    }


    public function update(Request $request){
        $id = $request->{"id"};
        $jenis = $request->{"jenis"};
        $nama = $request->{"nama"};
        $keterangan = $request->{"keterangan"};
        if(!$id){
            return redirect(url("kontak"))->with("error", "Parameter incomplete (id)");
        }
        if(!$jenis){
            return redirect(url("kontak"))->with("error", "Parameter incomplete (jenis)");
        }
        if(!$nama){
            return redirect(url("kontak"))->with("error", "Parameter incomplete (nama)");
        }
        if(!$keterangan){
            return redirect(url("kontak"))->with("error", "Parameter incomplete (keterangan)");
        }

        $lastData = Kontak::find($id);
        if(!$lastData){
            return redirect(url("kontak"))->with("error", "Kontak tidak ditemukan");
        }

        $lastData->jenis = $jenis;
        $lastData->nama = $nama;
        $lastData->keterangan = $keterangan;
        $lastData->save();
        
        return redirect(url("kontak"))->with("success", "Kontak berhasil diperbarui");
    }


    public function delete(Request $request){
        $id = $request->{"id"};
        if(!$id){
            return redirect(url("kontak"))->with("error", "Inputan tidak valid");
        }

        $lastData = Kontak::find($id);
        if(count($lastData->get()) == 0){
            return redirect(url("kontak"))->with("error", "Kontak tidak ditemukan");
        }

        $lastData->delete();

        return redirect(url("kontak"))->with("success", "Kontak berhasil dihapus");
    }

}
