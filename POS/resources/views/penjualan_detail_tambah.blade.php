<!DOCTYPE html>
<html>
<head>
    <title>Data Penjualan Detail</title>
</head>
<body>
    <h1>Form Tambah Data Penjualan Detail</h1>
    <form method="post" action="/penjualan_detail/tambah_simpan">
        {{ csrf_field() }}

        <label>ID Penjualan</label>
        <input type="number" name="penjualan_id" placeholder="Masukkan ID Penjualan">
        <br>
        <label>ID Barang</label>
        <input type="number" name="barang_id" placeholder="Masukkan ID Barang">
        <br>
        <label>Harga</label>
        <input type="number" name="harga" placeholder="Masukkan Harga">
        <br>
        <label>Jumlah</label>
        <input type="number" name="jumlah" placeholder="Masukkan Jumlah">
        <br><br>
        <input type="submit" class="btn btn-success" value="Simpan">
    </form>
</body>
</html>