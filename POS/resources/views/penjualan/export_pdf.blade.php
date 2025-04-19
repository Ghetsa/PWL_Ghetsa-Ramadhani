<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 6px 20px 5px 20px;
            line-height: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 4px 3px;
        }

        th {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .d-block {
            display: block;
        }

        .font-10 {
            font-size: 10pt;
        }

        .font-11 {
            font-size: 11pt;
        }

        .font-13 {
            font-size: 13pt;
        }

        .border-bottom-header {
            border-bottom: 1px solid;
        }

        .border-all,
        .border-all th,
        .border-all td {
            border: 1px solid;
        }
    </style>
</head>

<body>
    <table class="border-bottom-header">
        <tr>
            <td width="15%" class="text-center">
                <img src="{{ asset('adminlte/dist/img/polinema-bw.png') }}" width="80%">
            </td>
            <td width="100%">
                <span class="text-center d-block font-11 font-bold mb-1">
                    KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI
                </span>
                <span class="text-center d-block font-13 font-bold mb-1">POLITEKNIK NEGERI MALANG</span>
                <span class="text-center d-block font-10">Jl. Soekarno-Hatta No. 9 Malang 65141</span>
                <span class="text-center d-block font-10">Telepon (0341) 404424, Fax. (0341) 404420</span>
                <span class="text-center d-block font-10">Laman: www.polinema.ac.id</span>
            </td>
        </tr>
    </table>

    <h3 class="text-center">LAPORAN DATA PENJUALAN</h3>

    <table class="border-all">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Tanggal</th>
                <th>Kode</th>
                <th>Pembeli</th>
                <th>Kasir</th>
                <th>Barang</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Jumlah</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach($penjualan as $i => $p)
                @foreach($p->detail as $d)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td>{{ date('d-m-Y', strtotime($p->penjualan_tanggal)) }}</td>
                        <td>{{ $p->penjualan_kode }}</td>
                        <td>{{ $p->pembeli }}</td>
                        <td>{{ $p->user->nama ?? '-' }}</td>
                        <td>{{ $d->barang->barang_nama ?? '-' }}</td>
                        <td class="text-right">{{ number_format($d->harga, 0, ',', '.') }}</td>
                        <td class="text-right">{{ $d->jumlah }}</td>
                        <td class="text-right">{{ number_format($d->harga * $d->jumlah, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                @php $grandTotal += $p->total_bayar; @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="8" class="text-right"><strong>Total Keseluruhan</strong></td>
                <td class="text-right"><strong>{{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
