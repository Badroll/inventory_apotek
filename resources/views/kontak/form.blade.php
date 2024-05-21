@extends("include.app")
@section("content")
    @php
        $editMode = isset($kontak);
        $title = "Edit Kontak";
        $formUrl = url('kontak/update');
        $formMethod = "PUT";
        $button = "Update";
        if(!$editMode){
            $title = "Buat Kontak Baru";
            $formUrl = url('kontak/create');
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
                        <input type="hidden" name="id" value="{{ $kontak->id }}">
                    @endif
                    <hr>
                    <div class="row mt-3  periksa-true">
                        <div class="col-md-6">
                            <div class="mt-3 mb-3 col-md-12">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" name="nama" id="nama" @if($editMode) value="{{ $kontak->nama }}" @endif>
                            </div>
                            <div class="mt-3 mb-3 col-md-12">
                                <label for="jenis" class="form-label">Jenis</label>
                                <select class="form-control" name="jenis" id="jenis">
                                    <option value="Supplier"
                                        @if($editMode && ($kontak->jenis == 'Supplier')) selected @endif
                                        >
                                        Supplier</option>
                                    <option value="Customer"
                                        @if($editMode && ($kontak->jenis == 'Customer')) selected @endif
                                        >
                                        Customer</option>
                                </select>
                            </div>
                            <div class="mt-3 mb-3 col-md-12">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control" name="keterangan" id="keterangan">@if($editMode) {{ $kontak->keterangan }} @endif</textarea>
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
        <form role="form" method="POST" action="{{ url('kontak/delete') }}" id="form_delete">
            @csrf
            @method("DELETE")
            <input type="hidden" name="id" value="{{ $kontak->id }}">
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