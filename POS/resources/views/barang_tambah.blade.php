<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
</head>
<body>
    <h1>Form Tambah Data Barang</h1>
    <form method="post" action="/barang/tambah_simpan">
        {{ csrf_field() }}

        <label>Kode Barang</label>
        <input type="text" name="barang_kode" placeholder="Masukkan Kode Barang">
        <br>
        <label>Nama Barang</label>
        <input type="text" name="barang_nama" placeholder="Masukkan Nama Barang">
        <br>
        <label>ID Kategori</label>
        <input type="number" name="kategori_id" placeholder="Masukkan ID Kategori">
        <br>
        <label>Harga Beli</label>
        <input type="number" name="harga_beli" placeholder="Masukkan Harga Beli">
        <br>
        <label>Harga Jual</label>
        <input type="number" name="harga_jual" placeholder="Masukkan Harga Jual">
        <br>
        <label>Stok</label>
        <input type="number" name="stok" placeholder="Masukkan Stok">
        <br>
        <label>ID Supplier</label>
        <input type="number" name="supplier_id" placeholder="Masukkan ID Supplier">
        <br><br>
        <input type="submit" class="btn btn-success" value="Simpan">
    </form>
</body>
</html>