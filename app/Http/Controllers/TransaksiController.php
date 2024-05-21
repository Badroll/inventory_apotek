<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use App\Models\Barang;
use App\Models\Kontak;
use Session, DB, PDF;

class TransaksiController extends Controller
{
    public $type = null;

    public function __construct(Request $request){
    }


    public function cekType(Request $request){
        $this->type = $request->{"type"};
        if(!$this->type) return back()->with("error", "Parameter tidak lengkap (type)");
    }


    public function index(Request $request){
        $this->cekType($request);

        $comp = "Pengadaan";
        if($this->type == "out"){
            $comp = "Penjualan";
        }
        $transaksi = Transaksi::where("jenis", $comp)->get();
        // foreach($transaksi as $k => $v){
        //     $items = TransaksiItem::where("transaksi_id", $v->{"id"})->get();
        //     $v->{"ITEMS"} = $items;
        // }

        $data["transaksi"] = $transaksi;
        $data["type"] = $this->type;
        return view("transaksi.index", $data);
    }


    public function create(Request $request){
        $this->cekType($request);

        $tanggal = $request->{"tanggal"};
        $mitra = $request->{"mitra"};
        $keterangan = $request->{"keterangan"};
        $items = $request->{"items"};
        if(!$tanggal) return back()->with("error", "Parameter tidak lengkap (tanggal)");
        if(!$mitra) return back()->with("error", "Parameter tidak lengkap (mitra)");
        if(!$keterangan) return back()->with("error", "Parameter tidak lengkap (keterangan)");
        if(!$items) return back()->with("error", "Parameter tidak lengkap (items)");
        $jenis = "Pengadaan";
        if($this->type == "out"){
            $jenis = "Penjualan";
        }

        $items = rtrim($items, "<n>");
        $item = explode("<n>", $items);
        $totalHarga = 0;

        DB::beginTransaction();
            $trx = new Transaksi;
            $trx->kode = strtoupper(uniqid());
            $trx->jenis = $jenis;
            $trx->tanggal = $tanggal;
            $trx->mitra_id = $mitra;
            $trx->keterangan = $keterangan;
            $trx->save();
            foreach($item as $k => $v){
                $field = explode("<s>", $v);
                $trxItem = new TransaksiItem;
                $trxItem->transaksi_id = $trx->id;
                $trxItem->barang_id = $field[0];
                $trxItem->harga = $field[3];
                $trxItem->jumlah = $field[2];
                $trxItem->save();
                $totalHarga += $trxItem->harga * $trxItem->jumlah;
            }
        DB::commit();

        $kontak = Kontak::find($mitra);
        $message = "*Halo, ada " . $jenis . " Barang baru*";
        $message .= "\n\n_detail:_";
        $message .= "\n- Kode\t: *#".$trx->kode."*";
        $message .= "\n- Jumlah\t: ".count($item);
        $message .= "\n- *TOTAL\t: ". idr($totalHarga) . "*";
        $message .= "\n- oleh\t: ".$kontak->{"nama"};
        $message .= "\n\n_catatan:_\n_" . $keterangan . "_";
        cURLPost("http://62.72.51.244:5555/send_wa_1", [
            "phone" => Session::get("user")->{"no_wa"},
            "message" => $message,
            "redirect" => url("transaksi")."?type=".$this->type
        ]);
        
        return redirect(url("transaksi/form")."?type=".$this->type."&id=".$trx->id)->with("success", "Transaksi berhasil disimpan");
    }


    public function form(Request $request){
        $this->cekType($request);
        
        $id = $request->{"id"};

        $jenis = "Pengadaan";
        $mitra = "Supplier";
        if($this->type == "out"){
            $jenis = "Penjualan";
            $mitra = "Customer";
        }
        $ref_barang = Barang::get();
        //$ref_barang = Barang::where("expired", ">", date("Y-m-d"))->get();
        $ref_mitra = Kontak::where("jenis", $mitra)->get();

        $data["ref_barang"] = $ref_barang;
        $data["ref_mitra"] = $ref_mitra;
        $data["type"] = $this->type;

        if(!$id){
            return view("transaksi.form", $data);
        }

        $lastData = Transaksi::find($id);
        if(!$lastData){
            return back()->with("error", "Transaksi tidak ditemukan");
        }

        $data["transaksi"] = $lastData;
        //dd($ref_barang[0]->getStok());
        return view("transaksi.form", $data);
    }


    public function update(Request $request){
        $this->cekType($request);
        
        $id = $request->{"id"};
        $tanggal = $request->{"tanggal"};
        $mitra = $request->{"mitra"};
        $keterangan = $request->{"keterangan"};
        $items = $request->{"items"};
        if(!$id) return back()->with("error", "Parameter tidak lengkap (id)");
        if(!$tanggal) return back()->with("error", "Parameter tidak lengkap (tanggal)");
        if(!$mitra) return back()->with("error", "Parameter tidak lengkap (mitra)");
        if(!$keterangan) return back()->with("error", "Parameter tidak lengkap (keterangan)");
        if(!$items) return back()->with("error", "Parameter tidak lengkap (items)");
        $jenis = "Pengadaan";
        if($this->type == "out"){
            $jenis = "Penjualan";
        }

        $items = rtrim($items, "<n>");
        $item = explode("<n>", $items);
        $totalHarga = 0;
        //dd($item);

        DB::beginTransaction();
            $trx = Transaksi::find($id);
            if(!$trx){
                return back()->with("error", "Transaksi tidak ditemukan");
            }
            $trx->tanggal = $tanggal;
            $trx->mitra_id = $mitra;
            $trx->keterangan = $keterangan;
            $trx->save();
            TransaksiItem::where("transaksi_id", $id)->delete();
            foreach($item as $k => $v){
                $field = explode("<s>", $v);
                $trxItem = new TransaksiItem;
                $trxItem->transaksi_id = $id;
                $trxItem->barang_id = $field[0];
                $trxItem->harga = $field[3];
                $trxItem->jumlah = $field[2];
                $trxItem->save();
                $totalHarga += $trxItem->harga * $trxItem->jumlah;
            }
        DB::commit();

        // $kontak = Kontak::find($mitra);
        // $message = "*Halo, ada " . $jenis . " Barang baru*";
        // $message .= "\n\n_detail:_";
        // $message .= "\n- Kode\t: *#".$trx->kode."*";
        // $message .= "\n- Jumlah\t: ".count($item);
        // $message .= "\n- *TOTAL\t: ". idr($totalHarga) . "*";
        // $message .= "\n- oleh\t: ".$kontak->{"nama"};
        // $message .= "\n\n_catatan:_\n_" . $keterangan . "_";
        // cURLPost("http://62.72.51.244:5555/send_wa_1", [
        //     "phone" => Session::get("user")->{"no_wa"},
        //     "message" => $message,
        //     "redirect" => url("transaksi")."?type=".$this->type
        // ]);
        
        return redirect(url("transaksi/form")."?type=".$this->type."&id=".$trx->id)->with("success", "Transaksi berhasil diperbarui");
    }


    public function delete(Request $request){
    
        $id = $request->{"id"};
        if(!$id) return back()->with("error", "Parameter tidak lengkap (id)");

        DB::beginTransaction();
            $lastData = Transaksi::find($id);
            if(!$lastData){
                return back()->with("error", "Transaksi tidak ditemukan");
            }
            $lastData->delete();
            TransaksiItem::where("transaksi_id", $id)->delete();
        DB::commit();

        return redirect(url("transaksi")."?type=".$this->type)->with("success", "Transaksi berhasil dihapus");
    }


    public function downloadInvoice(Request $request){
        $id = $request->{"id"};
        if(!$id) return back()->with("error", "Parameter tidak lengkap (id)");

        // Fetch invoice data from database
        $invoice = Transaksi::findOrFail($id);

        // Load view and pass data
        $pdf = PDF::loadView('invoice', compact('invoice'));

        // Download PDF file
        return $pdf->download('invoice_' . $invoice->kode . '.pdf');
    }

}
