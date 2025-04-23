<!DOCTYPE html>
<html>
<head>
    <title>Data Penjualan Detail</title>
</head>
<body>
    <h1>Form Ubah Data Penjualan Detail</h1>
    <a href="/penjualan_detail">Kembali</a>
    <br><br>
    <form method="post" action="/penjualan_detail/ubah_simpan/{{ $data->detail_id }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <label>ID Penjualan</label>
        <input type="number" name="penjualan_id" value="{{ $data->penjualan_id }}">
        <br>
        <label>ID Barang</label>
        <input type="number" name="barang_id" value="{{ $data->barang_id }}">
        <br>
        <label>Harga</label>
        <input type="number" name="harga" value="{{ $data->harga }}">
        <br>
        <label>Jumlah</label>
        <input type="number" name="jumlah" value="{{ $data->jumlah }}">
        <br><br>
        <input type="submit" class="btn btn-success" value="Ubah">
    </form>
</body>
</html>