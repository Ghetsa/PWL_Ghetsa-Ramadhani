<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Penjualan</title>
    <style>
        body {
            font-family: monospace;
            font-size: 12px;
            padding: 10px;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 10px;
        }
        .items td {
            padding: 3px 0;
        }
        .total {
            font-weight: bold;
        }
        .line {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h4>TOKO RUMAH BENING</h4>
        <p>Jl. Raya Kerek No. 123<br>Telp: 08123456789</p>
        <div class="line"></div>
        <p><strong>Kode:</strong> {{ $penjualan->penjualan_kode }}<br>
           <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($penjualan->penjualan_tanggal)->format('d/m/Y H:i') }}</p>
        <div class="line"></div>
    </div>

    <table width="100%" class="items">
        @foreach ($penjualan->detail as $item)
            <tr>
                <td colspan="3">{{ $item->barang->barang_nama ?? '-' }}</td>
            </tr>
            <tr>
                <td>{{ $item->jumlah }} x {{ number_format($item->harga, 0, ',', '.') }}</td>
                <td style="text-align:right;" colspan="2">Rp {{ number_format($item->jumlah * $item->harga, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </table>

    <div class="line"></div>

    <table width="100%">
        <tr>
            <td class="total">Total Bayar</td>
            <td class="total" style="text-align:right;">Rp {{ number_format($penjualan->total_bayar, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="footer">
        <p class="line"></p>
        <p>Terima kasih atas kunjungan Anda!</p>
    </div>
</body>
</html>
