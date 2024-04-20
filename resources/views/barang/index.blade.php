@extends("include.app")
@section("content")
    <h1 class="card-title mb-9 fw-semibold">Obat</h1>
    <div class="row">
        <div class="col-lg-12">
            @if(Session::get("user")->role == 2)
            <a href="{{ url('barang/form') }}" class="btn btn-primary" role="button" title="Tambah"><i class="glyphicon glyphicon-plus"></i> Tambah</a> 
            @endif
            <div class="table-responsive">
                <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">No</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Nama Obat</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Kategori</h6>
                            </th>
                            <!-- <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Harga</h6>
                            </th> -->
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Keterangan</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Aksi</h6>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($barang as $k => $v)  
                        <tr>
                            <td>{{ $k +1 }}</td>
                            <td>{{ $v->nama }}</td>
                            <td>{{ $v->kategori_nama }}</td>
                            <td>{{ $v->keterangan }}</td>
                            <td>
                                @if(Session::get("user")->role == 2)
                                <a href="{{ url('barang/form?id=' . $v->id) }}" class="btn btn-primary" role="button" title="Edit"><i class="glyphicon glyphicon-edit">Edit</i></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <script>
                </script>
            </div>
        </div>
    </div>
@endsection

@section("js")
@endsection