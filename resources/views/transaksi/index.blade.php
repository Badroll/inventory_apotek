@extends("include.app")
@section("content")
    @php
        $typeIn = $type === "in";
        $title = "Pengadaan";
        if(!$typeIn){
            $title = "Penjualan";
        }
    @endphp
    <h1 class="card-title mb-9 fw-semibold">Data {{ $title }} Obat</h1>
    <div class="row">
        <div class="col-lg-12">
            @if(Session::get("user")->role == 2)
            <a href="{{ url('transaksi/form') }}?type={{ $type }}" class="btn btn-primary" role="button" title="Tambah"><i class="glyphicon glyphicon-plus"></i> Tambah</a> 
            @endif
            <div class="table-responsive">
                <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>
                        <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">No</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Kode</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Tanggal</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Item</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Total</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">@if($typeIn) Supplier @else Customer @endif</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Aksi</h6>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi as $k => $v)  
                        <tr>
                            <td>{{ $k +1 }}</td>
                            <td><b>#{{ $v->kode }}</b></td>
                            <td>{!! str_replace(" ", " ", tglIndo($v->tanggal, "SHORT")) !!}</td>
                            <td>{{ count($v->transaksiItem) }} item(s)</td>
                            <td>{{ idr($v->getTotalHarga()) }}</td>
                            <td>{{ ($v->mitra->nama) }}</td>
                            <td>
                                @if(Session::get("user")->role == 2)
                                <a href="{{ url('transaksi/form') }}?type={{ $type }}&id={{ $v->id }}" class="btn btn-primary" role="button" title="Edit"><i class="glyphicon glyphicon-edit">Edit</i></a>
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