@extends("include.app")
@section("content")
    @php
        $typeIn = $type === "in";
        $menu = "Penjualan";
        $mitra = "Customer";
        if($typeIn){
            $menu = "Pengadaan";
            $mitra = "Supplier";
        }

        $editMode = isset($transaksi);
        $title = "Edit " . $menu . " Obat";
        $formUrl = url('transaksi/update');
        $formMethod = "PUT";
        $button = "Update";
        if(!$editMode){
            $title = "Buat " . $menu . " Obat Baru";
            $formUrl = url('transaksi/create');
            $formMethod = "POST";
            $button = "Simpan";
        }
    @endphp
    <h1 class="card-title mb-9 fw-semibold">{{ $title }}</h1>
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <form role="form" method="POST" action="{{ $formUrl }}">
                    @csrf
                    @method($formMethod)
                    @if($editMode)
                        <input type="hidden" name="id" value="{{ $transaksi->id }}">
                    @endif
                    <input type="hidden" name="type" value="{{ $type }}">
                    <hr>
                    <div class="row mt-3  periksa-true">
                        <div class="col-md-6">
                            <div class="mt-3 mb-3 col-md-12">
                                <label for="kode" class="form-label">Kode</label>
                                <input type="text" class="form-control" name="kode" id="kode" @if($editMode) value="{{ $transaksi->kode }}" @endif>
                            </div>
                            <div class="mt-3 mb-3 col-md-12">
                                <label for="barang" class="form-label">Obat</label>
                                <select class="form-control" name="barang_id" id="barang" @if($editMode) disabled @endif>
                                    @foreach($ref_barang as $k => $v)
                                        <option value="{{ $v->id }}"
                                        @if($editMode && ($transaksi->barang_id == $v->id)) selected @endif
                                        >
                                        {{ $v->nama }} - {{ $v->kategori_nama }} (stok: {{ $v->stok }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-3 mb-3 col-md-12">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" name="jumlah" id="jumlah" @if($editMode) value="{{ $transaksi->jumlah }}" disabled @endif>
                            </div>
                            <div class="mt-3 mb-3 col-md-12">
                                <label for="harga" class="form-label">Harga</label>
                                <input type="number" class="form-control" name="harga" id="harga" @if($editMode) value="{{ $transaksi->harga }}" @endif>
                            </div>
                            <div class="mt-3 mb-3 col-md-12">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="text" class="form-control" name="tanggal" id="tanggal" @if($editMode) value="{{ $transaksi->tanggal }}" @endif>
                            </div>
                            <div class="mt-3 mb-3 col-md-12">
                                <label for="mitra" class="form-label">{{ $mitra }}</label>
                                <input type="text" class="form-control" name="mitra" id="mitra" @if($editMode) value="{{ $transaksi->mitra }}" @endif>
                            </div>
                            <div class="mt-3 mb-3 col-md-12">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control" name="keterangan" id="keterangan">@if($editMode) {{ $transaksi->keterangan }} @endif</textarea>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">{{ $button }}</button>
                    @if($editMode)<a class="btn btn-danger" id="button_form_hapus">Hapus</a>@endif
                </form>
            </div>
        </div>
    </div>

    @if($editMode)
        <form role="form" method="POST" action="{{ url('transaksi/delete') }}" id="form_delete">
            @csrf
            @method("DELETE")
            <input type="hidden" name="id" value="{{ $transaksi->id }}">
            <input type="hidden" name="type" value="{{ $type }}">
        </form>
    @endif

@endsection

@section("js")
    <script type="text/javascript">
        
        $("#button_form_hapus").on("click", function(){
            $("#form_delete").submit()
        })

        

    </script>
@endsection