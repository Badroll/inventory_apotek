<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        /* Tambahkan gaya CSS sesuai kebutuhan */
        body {
            font-family: Arial, sans-serif;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-details {
            margin-bottom: 20px;
        }
        .invoice-items {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-items th, .invoice-items td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .invoice-items th {
            background-color: #f2f2f2;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="invoice-header">
            <h1>Invoice {{ $invoice->jenis }}<br>#{{ $invoice->kode }}</h1>
        </div>
        <div class="invoice-details">
            <p>Mitra &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <strong>{{ $invoice->mitra->nama }} - {{ $invoice->mitra->keterangan }}</strong></p>
            <p>Tanggal &nbsp;: <strong>{{ tglIndo($invoice->tanggal, "LONG") }}</strong></p>
        </div>
        <table class="invoice-items">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Obat</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach($invoice->transaksiItem as $k => $item)
                    @php
                        $subTotal = $item->jumlah * $item->harga;
                        $total += $subTotal;
                    @endphp
                <tr>
                    <td>{{ $k + 1 }}</td>
                    <td>{{ $item->barang->nama }}</td>
                    <td>{{ $item->jumlah }} x {{ idr($item->harga) }}</td>
                    <td>{{ idr($subTotal) }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3" style="text-align: right;"><b>T O T A L</b></td>
                    <td><b>{{ idr($total) }}</b></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
