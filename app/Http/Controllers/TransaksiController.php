<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Barang;
use Session, DB;

class TransaksiController extends Controller
{
    public $type = null;

    public function __construct(Request $request){
        $this->type = $request->{"type"};
        if(!$this->type) return back()->with("error", "Parameter tidak lengkap (type)");
    }


    public function index(Request $request){
        $comp = ">";
        if($this->type == "out"){
            $comp = "<";
        }
        $transaksi = DB::select("
            SELECT A.*, B.nama as barang_nama, C.nama as kategori_nama
            FROM transaksi as A
            JOIN barang as B ON A.barang_id = B.id
            JOIN kategori as C ON B.kategori_id = C.id
            WHERE A.jumlah ".$comp." 0
        ", []);
        foreach($transaksi as $k => $v){
            $v->{"total"} = $v->{"jumlah"} * $v->{"harga"};
        }

        $data["transaksi"] = $transaksi;
        $data["type"] = $this->type;
        return view("transaksi.index", $data);
    }


    public function create(Request $request){
        $kode = $request->{"kode"};
        $barang_id = $request->{"barang_id"};
        $tanggal = $request->{"tanggal"};
        $harga = $request->{"harga"};
        $jumlah = $request->{"jumlah"};
        $mitra = $request->{"mitra"};
        $keterangan = $request->{"keterangan"};
        if(!$kode) return back()->with("error", "Parameter tidak lengkap (kode)");
        if(!$barang_id) return back()->with("error", "Parameter tidak lengkap (barang_id)");
        if(!$tanggal) return back()->with("error", "Parameter tidak lengkap (tanggal)");
        if(!$harga) return back()->with("error", "Parameter tidak lengkap (harga)");
        if(!$jumlah) return back()->with("error", "Parameter tidak lengkap (jumlah)");
        if(!$mitra) return back()->with("error", "Parameter tidak lengkap (mitra)");
        if(!$keterangan) return back()->with("error", "Parameter tidak lengkap (keterangan)");
        $menu = "Pengadaan";
        if($this->type == "out"){
            $jumlah = "-" . $jumlah;
            $menu = "Penjualan";
        }

        DB::beginTransaction();
            if($this->updateStok($barang_id, $jumlah) === false){
                return back()->with("error", "Transaksi gagal, stok barang tidak cukup");
            }
            $trx = new Transaksi;
            $trx->kode = $kode;
            $trx->barang_id = $barang_id;
            $trx->tanggal = $tanggal;
            $trx->harga = $harga;
            $trx->jumlah = $jumlah;
            $trx->mitra = $mitra;
            $trx->keterangan = $keterangan;
            $trx->save();
        DB::commit();
        $barang = Barang::find($barang_id);
        $message = "*Halo, ada " . $menu . " Barang baru*";
        $message .= "\n\n_detail:_";
        $message .= "\n- Kode\t: *#".$kode."*";
        $message .= "\n- Barang\t: ".$barang->{"nama"};
        $message .= "\n- Jumlah\t: ".$jumlah;
        $message .= "\n- Harga\t: ".idr($harga);
        $message .= "\n- *TOTAL\t: ". idr($harga * $jumlah) . "*";
        $message .= "\n- oleh\t: ".$mitra;
        $message .= "\n\n_catatan:_\n_" . $keterangan . "_";
        cURLPost("http://62.72.51.244:5555/send_wa_1", [
            "phone" => Session::get("user")->{"no_wa"},
            "message" => $message,
            "redirect" => url("transaksi")."?type=".$this->type
        ]);
        
        return redirect(url("transaksi")."?type=".$this->type)->with("success", "Transaksi berhasil disimpan");
    }


    public function form(Request $request){
        $id = $request->{"id"};
        $qry = "
            SELECT A.*, B.nama as kategori_nama
            FROM barang as A
            JOIN kategori as B ON A.kategori_id = B.id
        ";
        if($this->type == "out"){
            $qry .= "WHERE A.stok > 0";
        }
        $ref_barang = DB::select($qry, []);
        $data["ref_barang"] = $ref_barang;
        $data["type"] = $this->type;

        if(!$id){
            return view("transaksi.form", $data);
        }

        $lastData = Transaksi::find($id);
        if(!$lastData){
            return back()->with("error", "Transaksi tidak ditemukan");
        }

        $data["transaksi"] = $lastData;
        return view("transaksi.form", $data);
    }


    public function update(Request $request){
        $id = $request->{"id"};
        $kode = $request->{"kode"};
        //$barang_id = $request->{"barang_id"};
        $tanggal = $request->{"tanggal"};
        $harga = $request->{"harga"};
        //$jumlah = $request->{"jumlah"};
        $mitra = $request->{"mitra"};
        $keterangan = $request->{"keterangan"};
        if(!$id) return back()->with("error", "Parameter tidak lengkap (id)");
        if(!$kode) return back()->with("error", "Parameter tidak lengkap (kode)");
        //if(!$barang_id) return back()->with("error", "Parameter tidak lengkap (barang_id)");
        if(!$harga) return back()->with("error", "Parameter tidak lengkap (harga)");
        if(!$tanggal) return back()->with("error", "Parameter tidak lengkap (tanggal)");
        //if(!$jumlah) return back()->with("error", "Parameter tidak lengkap (jumlah)");
        if(!$mitra) return back()->with("error", "Parameter tidak lengkap (mitra)");
        if(!$keterangan) return back()->with("error", "Parameter tidak lengkap (keterangan)");
        if($this->type == "out"){
            $jumlah = "-" . $jumlah;
        }

        $trx = Transaksi::find($id);
        if(!$trx){
            return back()->with("error", "Transaksi tidak ditemukan");
        }

        DB::beginTransaction();
            // if($this->updateStok($barang_id, $jumlah) === false){
            //     return back()->with("error", "Transaksi gagal, stok barang tidak cukup");
            // }
            $trx->kode = $kode;
            //$trx->barang_id = $barang_id;
            $trx->tanggal = $tanggal;
            $trx->harga = $harga;
            //$trx->jumlah = $jumlah;
            $trx->mitra = $mitra;
            $trx->keterangan = $keterangan;
            $trx->save();
        DB::commit();
        
        return redirect(url("transaksi")."?type=".$this->type)->with("success", "Transaksi berhasil disimpan");
    }


    public function updateStok($id, $jumlah){
        $barang = Barang::find($id);
        $newStok = $barang->{"stok"} + intval($jumlah);
        if($newStok < 0 ){
            return false;
        }
        $barang->stok = $newStok;
        $barang->save();
        return true;
    }


    public function delete(Request $request){
        $id = $request->{"id"};
        if(!$id) return back()->with("error", "Parameter tidak lengkap (id)");

        DB::beginTransaction();
            $lastData = Transaksi::find($id);
            if(count($lastData->get()) == 0){
                return back()->with("error", "Transaksi tidak ditemukan");
            }
            
            $multiplier = 1;
            if($this->type === "in"){
                $multiplier = -1;
            }
            if($this->updateStok($lastData->{"barang_id"}, $lastData->{"jumlah"} * $multiplier) === false){
                return back()->with("error", "Transaksi gagal, stok barang tidak cukup");
            }

            $lastData->delete();
        DB::commit();

        return redirect(url("transaksi")."?type=".$this->type)->with("success", "Transaksi berhasil dihapus");
    }


    public function cashflow(Request $request){
        $periode = $request->{"periode"};
        $qry = "
            SELECT A.*, B.nama as barang_nama, C.nama as kategori_nama
            FROM transaksi as A
            JOIN barang as B ON A.barang_id = B.id
            JOIN kategori as C ON B.kategori_id = C.id
            WHERE 0
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
