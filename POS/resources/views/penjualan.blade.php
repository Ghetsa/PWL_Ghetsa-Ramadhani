<!DOCTYPE html>
<html>
<head>
    <title>Data Penjualan</title>
</head>
<body>
    <h1>Data Penjualan</h1>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>Penjualan ID</th>
            <th>User ID</th>
            <th>Pembeli</th>
            <th>Kode Penjualan</th>
            <th>Tanggal Penjualan</th>
        </tr>
        @foreach ($data as $d)
        <tr>
            <td>{{ $d->penjualan_id }}</td>
            <td>{{ $d->user_id }}</td>
            <td>{{ $d->pembeli }}</td>
            <td>{{ $d->penjualan_kode }}</td>
            <td>{{ $d->tanggal_penjualan }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>