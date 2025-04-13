<!DOCTYPE html>
<html>
<head>
    <title>Data Penjualan</title>
</head>
<body>
    <h1>Form Tambah Data Penjualan</h1>
    <form method="post" action="/penjualan/tambah_simpan">
        {{ csrf_field() }}

        <label>ID User</label>
        <input type="number" name="user_id" placeholder="Masukkan ID User">
        <br>
        <label>Pembeli</label>
        <input type="text" name="pembeli" placeholder="Masukkan Nama Pembeli">
        <br>
        <label>Kode Penjualan</label>
        <input type="text" name="penjualan_kode" placeholder="Masukkan Kode Penjualan">
        <br>
        <label>Tanggal Penjualan</label>
        <input type="date" name="penjualan_tanggal">
        <br><br>
        <input type="submit" class="btn btn-success" value="Simpan">
    </form>
</body>
</html>
