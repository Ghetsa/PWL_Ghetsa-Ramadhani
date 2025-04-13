<!DOCTYPE html>
<html>
<head>
    <title>Data Stok</title>
</head>
<body>
    <h1>Data Stok</h1>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>Stok ID</th>
            <th>Barang ID</th>
            <th>User ID</th>
            <th>Supplier ID</th>
            <th>Tanggal masuk</th>
            <th>Jumlah</th>
        </tr>
        @foreach ($data as $d)
        <tr>
            <td>{{ $d->stok_id }}</td>
            <td>{{ $d->barang_id }}</td>
            <td>{{ $d->user_id }}</td>
            <td>{{ $d->supplier_id }}</td>
            <td>{{ $d->stok_tanggal_masuk }}</td>
            <td>{{ $d->stok_jumlah }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>