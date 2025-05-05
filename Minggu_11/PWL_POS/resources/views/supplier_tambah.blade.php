<!DOCTYPE html>
<html>
<head>
    <title>Data Supplier</title>
</head>
<body>
    <h1>Form Tambah Data Supplier</h1>
    <form method="post" action="/supplier/tambah_simpan">
        {{ csrf_field() }}

        <label>Kode Supplier</label>
        <input type="text" name="supplier_kode" placeholder="Masukkan Kode Supplier">
        <br>
        <label>Nama Supplier</label>
        <input type="text" name="supplier_nama" placeholder="Masukkan Nama Supplier">
        <br><br>
        <input type="submit" class="btn btn-success" value="Simpan">
    </form>
</body>
</html>