<!DOCTYPE html>
<html>
<head>
    <title>Data Stok</title>
</head>
<body>
    <h1>Form Tambah Data Stok</h1>
    <form method="post" action="/stok/tambah_simpan">
        {{ csrf_field() }}

        <label>ID Barang</label>
        <input type="number" name="barang_id" placeholder="Masukkan ID Barang">
        <br>
        <label>ID User</label>
        <input type="number" name="user_id" placeholder="Masukkan ID User">
        <br>
        <label>Tanggal Stok</label>
        <input type="date" name="stok_tanggal">
        <br>
        <label>Jumlah Stok</label>
        <input type="number" name="stok_jumlah" placeholder="Masukkan Jumlah">
        <br><br>
        <input type="submit" class="btn btn-success" value="Simpan">
    </form>
</body>
</html>