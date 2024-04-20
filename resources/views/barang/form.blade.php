@extends("include.app")
@section("content")
    @php
        $editMode = isset($barang);
        $title = "Edit Obat";
        $formUrl = url('barang/update');
        $formMethod = "PUT";
        $button = "Update";
        if(!$editMode){
            $title = "Buat Obat Baru";
            $formUrl = url('barang/create');
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
                        <input type="hidden" name="id" value="{{ $barang->id }}">
                    @endif
                    <hr>
                    <div class="row mt-3  periksa-true">
                        <div class="col-md-6">
                            <div class="mt-3 mb-3 col-md-12">
                                <label for="nama" class="form-label">Nama Obat</label>
                                <input type="text" class="form-control" name="nama" id="nama" @if($editMode) value="{{ $barang->nama }}" @endif>
                            </div>
                            <div class="mt-3 mb-3 col-md-12">
                                <label for="kategori" class="form-label">Kategori</label>
                                <select class="form-control" name="kategori_id" id="kategori">
                                    @foreach($ref_kategori as $k => $v)
                                        <option value="{{ $v->id }}"
                                        @if($editMode && ($barang->kategori_id == $v->id)) selected @endif
                                        >
                                        {{ $v->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- <div class="mt-3 mb-3 col-md-12">
                                <label for="nama" class="form-label">Harga</label>
                                <input type="number" class="form-control" name="harga" id="harga" @if($editMode) value="{{ $barang->harga }}" @endif>
                            </div> -->
                            <div class="mt-3 mb-3 col-md-12">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control" name="keterangan" id="keterangan">@if($editMode) {{ $barang->keterangan }} @endif</textarea>
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
        <form role="form" method="POST" action="{{ url('barang/delete') }}" id="form_delete">
            @csrf
            @method("DELETE")
            <input type="hidden" name="id" value="{{ $barang->id }}">
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