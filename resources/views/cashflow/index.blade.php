@extends("include.app")
@section("content")
    <h1 class="card-title mb-9 fw-semibold">Cashflow</h1>
    <div class="row">
        <div class="col-lg-12">
            <div class="mt-2 mb-2 col-md-4">
                <label for="kategori" class="form-label">Periode</label>
                <select class="form-control" onchange="filter(this)">
                    <option value="s" @if($periode == "s") selected  @endif>SEMUA</option>
                    <option value="y" @if($periode == "y") selected  @endif>TAHUN INI</option>
                    <option value="m" @if($periode == "m") selected  @endif>BULAN INI</option>
                    <option value="d" @if($periode == "d") selected  @endif>HARI INI</option>
                </select>
            </div>
            <div class="table-responsive">
                <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Tanggal</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Obat</h6>
                            </th>
                            <!-- <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Sumber</h6>
                            </th> -->
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Jumlah</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Harga</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Total</h6>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $grandTotal = 0;
                        @endphp
                        @foreach($cashflow as $k => $v)
                            @php
                                $total = $v->harga * $v->jumlah;
                                $cls = "primary";
                                $multiplier = -1;
                                if($v->jenis == "Penjualan"){
                                    $cls = "success";
                                    $multiplier = 1;
                                }
                                $grandTotal += $total * $multiplier;
                            @endphp
                            <tr class="alert alert-{{$cls}}">
                                <td>{!! str_replace(" ", " ", tglIndo($v->tanggal, "SHORT")) !!}</td>
                                <td><b>{{ $v->barang_nama }}</b><br>{{ $v->kategori_nama }}</td>
                                <td>{{ $v->jumlah }} ({{ $cls == "success" ? "+" : "-" }})</td>
                                <td>{{ idr($v->harga) }}</td>
                                <td><b>{{ idr($total) }} ({{ $cls == "success" ? "+" : "-" }})</b></td>
                            </tr>
                        @endforeach
                        <tr class="">
                            <td colspan="3"></td>
                            <td><b></b></td>
                            <td><h5 @if($grandTotal < 0)  @endif>{{ idr($grandTotal) }}</h5></td>
                        </tr>
                    </tbody>
                </table>
                <script>
                </script>
            </div>
        </div>
    </div>
@endsection

@section("js")
<script type="text/javascript">
        
    function filter(el){
        window.location = "{{ url('cashflow') }}?periode=" + $(el).val()
    }

</script>
@endsection