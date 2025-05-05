<!DOCTYPE html>
<html>
<head>
    <title>Data Stok</title>
</head>
<body>
    <h1>Form Ubah Data Stok</h1>
    <a href="/stok">Kembali</a>
    <br><br>
    <form method="post" action="/stok/ubah_simpan/{{ $data->stok_id }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <label>ID Barang</label>
        <input type="number" name="barang_id" value="{{ $data->barang_id }}">
        <br>
        <label>ID User</label>
        <input type="number" name="user_id" value="{{ $data->user_id }}">
        <br>
        <label>Tanggal Stok</label>
        <input type="date" name="stok_tanggal" value="{{ $data->stok_tanggal }}">
        <br>
        <label>Jumlah Stok</label>
        <input type="number" name="stok_jumlah" value="{{ $data->stok_jumlah }}">
        <br><br>
        <input type="submit" class="btn btn-success" value="Ubah">
    </form>
</body>
</html>