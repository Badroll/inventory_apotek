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
                            @if($editMode)
                            <div class="mt-3 mb-3 col-md-12">
                                <label for="kode" class="form-label">Kode</label>
                                <input type="text" class="form-control" name="kode" id="kode" @if($editMode) disabled value="{{ $transaksi->kode }}" @endif>
                            </div>
                            @endif
                            <div class="mt-3 mb-3 col-md-12">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="text" class="form-control" name="tanggal" id="tanggal" @if($editMode) value="{{ $transaksi->tanggal }}" @endif>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-3 mb-3 col-md-12">
                                <label for="mitra" class="form-label">{{ $mitra }}</label>
                                <select class="form-control" name="mitra" id="mitra" @if($editMode) @endif>
                                    @foreach($ref_mitra as $k => $v)
                                        <option value="{{ $v->id }}"
                                        @if($editMode && ($transaksi->mitra_id == $v->id)) selected @endif
                                        >{{ $v->nama }} - {{ $v->keterangan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-3 mb-3 col-md-12">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control" name="keterangan" id="keterangan">@if($editMode) {{ $transaksi->keterangan }} @endif</textarea>
                            </div>
                        </div>
                        <hr>

                        <div class="col-md-4">
                            <div class="mt-3 mb-3 col-md-12">
                                <label for="barang" class="form-label">Obat</label>
                                <select class="form-control" id="barang" @if($editMode) style="display:none;" @endif>
                                    <option value="_PILIH_">(pilih)</option>
                                    @foreach($ref_barang as $k => $v)
                                        @if((!$typeIn && $v->getStok() == 0))
                                        @else
                                            <option value="{{ $v->id }}"
                                            data-stok="{{ $v->getStok() }}"
                                            data-minimum="{{ $v->stok_minimum }}"
                                            @if($editMode && ($transaksi->barang_id == $v->id)) selected @endif
                                            >{{ $v->nama }} - {{ $v->kategori_nama }} (stok: {{ $v->getStok() }})</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mt-3 mb-3 col-md-12">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="jumlah" @if($editMode) value="{{ $transaksi->jumlah }}" disabled @endif>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mt-3 mb-3 col-md-12">
                                <label for="harga" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="harga" @if($editMode) value="{{ $transaksi->harga }}" @endif>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mt-3 mb-3 col-md-12">
                                <br>
                                <a class="btn btn-success" id="button_add_item">Tambah</a>
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" name="items" id="items" value="">

                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle" id="tableMain">
                            <thead class="text-dark fs-4">
                            </thead>
                            <tbody>
                                @if(isset($transaksi))
                                @foreach($transaksi->transaksiItem as $k => $v)
                                @php
                                    $total = 0;
                                @endphp
                                <tr>
                                    <td width="20%">{{ $v->barang->nama }} - {{ $v->barang->kategori->nama }}</td>
                                    <td width="20%" style="text-align: right;">{{ $v->jumlah }}</td>
                                    <td width="20%" style="text-align: right;">{{ ($v->harga) }}</td>
                                    <td width="10%">
                                        <!-- <a href="#tableMain" class="btn btn-warning" id="button_hapus_item">Hapus</a> -->
                                    </td>
                                    @php
                                        $total += $v->jumlah * $v->harga;
                                    @endphp
                                    <script>
                                        var currentItems = document.getElementById('items').value
                                        document.getElementById('items').value = currentItems + "{{ $v->barang_id }}<s>{{ $v->barang->nama }}<s>{{ $v->jumlah }}<s>{{ $v->harga }}<n>"
                                    </script>
                                </tr>
                                @endforeach
                                @endif
                                <tr>
                                    <td width="40%" colspan="2" style="text-align: right;"><b>T O T A L</b></td>
                                    <td width="20%" style="text-align: right;"><b id="displayTotal">{{ isset($total) ? $total : "0" }}</b></td>
                                    <td width="10%">
                                        <!-- <a href="#tableMain" class="btn btn-warning" id="button_hapus_item">Hapus</a> -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <br><br>
                    <div class="row">
                        <div class="col-md-9">
                            <button class="btn btn-primary" type="submit" id="btnSubmit">{{ $button }}</button>
                            @if($editMode)<a class="btn btn-danger" id="button_form_hapus">Hapus</a>@endif
                        </div>
                        <div class="col-md-3" style="align: right;">
                            @if($editMode)<a target="blank" href="{{ url('transaksi/invoice') }}?id={{ $transaksi->id }}" class="btn btn-success" id="button_form_hapus">Invoice</a>@endif
                        </div>
                    </div>
                </form>
                <script>
                    var typeIn = "{{ $type }}" === "in"
                    var strItems = "";
                    var selectBarang = document.getElementById('barang')
                    var total = 0;

                    document.getElementById('button_add_item').addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        var selectedOption = selectBarang.selectedOptions[0];
                        var obat = selectedOption.value;
                        var obatKet = selectedOption.text;
                        var obatStok = selectedOption.getAttribute('data-stok');
                        var obatMinimum = selectedOption.getAttribute('data-minimum');

                        var jumlah = document.getElementById('jumlah').value;
                        var harga = document.getElementById('harga').value;

                        if(!typeIn){
                            if(parseInt(jumlah) > parseInt(obatStok)){
                                alert("Stok tidak cukup, maksimal penjualan adalah " + obatStok)
                                document.getElementById('jumlah').value = obatStok;
                                return
                            }

                            if((parseInt(obatStok) - parseInt(jumlah)) < parseInt(obatMinimum)){
                                alert(`Peringatan! jumlah penjualan (${jumlah}) akan melewati batas minimal stok (${obatMinimum})`)
                            }
                        }

                        var newRow = document.createElement('tr');

                        var obatCell = document.createElement('td');
                        obatCell.textContent = obatKet;
                        obatCell.style.width = "20%";

                        var jumlahCell = document.createElement('td');
                        jumlahCell.textContent = jumlah;
                        jumlahCell.style.width = "20%";
                        jumlahCell.style.textAlign = "right";
                        
                        var hargaCell = document.createElement('td');
                        hargaCell.textContent = harga;
                        hargaCell.style.width = "20%";
                        hargaCell.style.textAlign = "right";

                        var deleteCell = document.createElement('td');
                        deleteCell.style.width = "10%";
                        var deleteButton = document.createElement('a');

                        deleteButton.textContent = 'Hapus';
                        deleteButton.className = 'btn btn-warning';
                        deleteButton.href = '#tableMain';
                        var pattern = obat + "<s>" + obatKet + "<s>" + jumlah + "<s>" + harga + "<n>"
                        deleteButton.addEventListener('click', function() {
                            strItems = strItems.replaceAll(pattern, "")
                            console.log(strItems)
                            document.getElementById('items').value = strItems
                            newRow.remove();

                            total -= parseInt(jumlah) * parseInt(harga)
                            document.getElementById('displayTotal').innerHTML = total

                            // add option
                            var option = document.createElement('option');
                            option.value = obat;
                            option.setAttribute("data-stok", obatStok);
                            option.textContent = obatKet;
                            selectBarang.appendChild(option);

                            cekItem()
                        });

                        deleteCell.appendChild(deleteButton);
                        newRow.appendChild(obatCell);
                        newRow.appendChild(jumlahCell);
                        newRow.appendChild(hargaCell);
                        newRow.appendChild(deleteCell);

                        var table = document.querySelector('#tableMain tbody');
                        var lastRow = table.lastElementChild;
                        table.insertBefore(newRow, lastRow);

                        strItems += pattern
                        console.log(strItems)
                        document.getElementById('items').value = strItems

                        total += parseInt(jumlah) * parseInt(harga)
                        document.getElementById('displayTotal').innerHTML = total

                        // remove option
                        var optionToRemove = selectBarang.querySelector('option[value="' + obat + '"]');
                        selectBarang.removeChild(optionToRemove);
                        document.getElementById('jumlah').value = '';
                        document.getElementById('harga').value = '';
                        let selectJumlah = document.getElementById('jumlah')
                        let selectHarga = document.getElementById('harga')
                        let btn = document.getElementById('button_add_item')
                        selectJumlah.style.display = "none"
                        selectHarga.style.display = "none"
                        btn.style.display = "none"

                        cekItem()
                    });

                    selectBarang.addEventListener('change', function(e) {
                        toggleForm()
                    });

                    toggleForm()
                    cekItem()


                    function toggleForm(){
                        var selectedOption = selectBarang.selectedOptions[0];
                        var obat = selectedOption.value;
                        var obatKet = selectedOption.text;
                        var obatStok = selectedOption.getAttribute('data-stok');
                        var obatMinimum = selectedOption.getAttribute('data-minimum');

                        let selectJumlah = document.getElementById('jumlah')
                        let selectHarga = document.getElementById('harga')
                        let btn = document.getElementById('button_add_item')

                        selectJumlah.style.display = "none"
                        selectHarga.style.display = "none"
                        btn.style.display = "none"

                        console.log(obat)
                        if(obat == "_PILIH_"){
                            return
                        }

                        if(!typeIn){
                            if(parseInt(obatStok) < parseInt(obatMinimum)){
                                alert(`Peringatan! stok obat ini (${obatStok}) kurang dari minimal stok (${obatMinimum})`)
                            }
                        }

                        selectJumlah.style.display = "block"
                        selectHarga.style.display = "block"
                        btn.style.display = "block"
                    }

                    function cekItem(){
                        let btn = document.getElementById('btnSubmit')
                        if(document.getElementById('items').value == ""){
                            btn.disabled = true
                        }else{
                            btn.disabled = false
                        }
                    }

                </script>
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