<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Session;

class KategoriController extends Controller
{
    public function __construct(){
    }


    public function index(Request $request){
        $kategori = Kategori::all();

        $data["kategori"] = $kategori;
        return view("kategori.index", $data);
    }


    public function create(Request $request){
        $nama = $request->{"nama"};
        if(!$nama){
            return redirect(url("kategori"))->with("error", "Inputan tidak valid");
        }
        // Kategori::insertGetId([
        //     "nama" => $nama
        // ]);
        $kategori = new Kategori;
        $kategori->nama = $nama;
        $kategori->save();
        
        //Session::flash("success", "Kategori berhasil dibuat");
        return redirect(url("kategori"))->with("success", "Kategori berhasil disimpan");
    }


    public function form(Request $request){
        $id = $request->{"id"};
        if(!$id){
            return view("kategori.form");
        }

        $lastData = Kategori::find($id);
        if(!$lastData){
            return redirect(url("kategori"))->with("error", "Kategori tidak ditemukan");
        }

        $data["kategori"] = $lastData;
        return view("kategori.form", $data);
    }


    public function update(Request $request){
        $id = $request->{"id"};
        $nama = $request->{"nama"};
        if(!$id || !$nama){
            return redirect(url("kategori"))->with("error", "Inputan tidak valid");
        }

        $lastData = Kategori::find($id);
        if(!$lastData){
            return redirect(url("kategori"))->with("error", "Kategori tidak ditemukan");
        }

        if($nama != $lastData->{"nama"}){
            $cekDuplikat = Kategori::where("nama", $nama)->where("id", "!=", $id)->get();
            if(count($cekDuplikat) > 0){
                return redirect(url("kategori"))->with("error", "Nama kategori '".$nama."' sudah digunakan");
            }
        }
        $lastData->nama = $nama;
        $lastData->save();
        
        return redirect(url("kategori"))->with("success", "Kategori berhasil diperbarui");
    }


    public function delete(Request $request){
        $id = $request->{"id"};
        if(!$id){
            return redirect(url("kategori"))->with("error", "Inputan tidak valid");
        }

        $lastData = Kategori::find($id);
        if(count($lastData->get()) == 0){
            return redirect(url("kategori"))->with("error", "Kategori tidak ditemukan");
        }

        $lastData->delete();

        return redirect(url("kategori"))->with("success", "Kategori berhasil dihapus");
    }

}
