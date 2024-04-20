@extends("include.app")
@section("content")
    @php
        $editMode = isset($kategori);
        $title = "Edit Kategori";
        $formUrl = url('kategori/update');
        $formMethod = "PUT";
        $button = "Update";
        if(!$editMode){
            $title = "Buat Kategori Baru";
            $formUrl = url('kategori/create');
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
                        <input type="hidden" name="id" value="{{ $kategori->id }}">
                    @endif
                    <hr>
                    <div class="row mt-3  periksa-true">
                        <div class="col-md-6">
                            <!-- <div class="mt-3 mb-3 col-md-12">
                                <label for="biaya_periksa" class="form-label">Biaya Periksa</label>
                                <select class="form-control" name="obat">
                                    <option>1</option>
                                </select>
                            </div> -->
                            <div class="mt-3 mb-3 col-md-12">
                                <label for="nama" class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control" name="nama" id="nama" @if($editMode) value="{{ $kategori->nama }}" @endif>
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
        <form role="form" method="POST" action="{{ url('kategori/delete') }}" id="form_delete">
            @csrf
            @method("DELETE")
            <input type="hidden" name="id" value="{{ $kategori->id }}">
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