<!DOCTYPE html>
<html>
<head>
    <title>Data Penjualan</title>
</head>
<body>
    <h1>Form Ubah Data Penjualan</h1>
    <a href="/penjualan">Kembali</a>
    <br><br>
    <form method="post" action="/penjualan/ubah_simpan/{{ $data->penjualan_id }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <label>ID User</label>
        <input type="number" name="user_id" value="{{ $data->user_id }}">
        <br>
        <label>Pembeli</label>
        <input type="text" name="pembeli" value="{{ $data->pembeli }}">
        <br>
        <label>Kode Penjualan</label>
        <input type="text" name="penjualan_kode" value="{{ $data->penjualan_kode }}">
        <br>
        <label>Tanggal Penjualan</label>
        <input type="date" name="penjualan_tanggal" value="{{ $data->penjualan_tanggal }}">
        <br><br>
        <input type="submit" class="btn btn-success" value="Ubah">
    </form>
</body>