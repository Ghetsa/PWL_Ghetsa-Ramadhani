<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
</head>
<body>
    <h1>Form Ubah Data Barang</h1>
    <a href="/barang">Kembali</a>
    <br><br>
    <form method="post" action="/barang/ubah_simpan/{{ $data->barang_id }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <label>Kode Barang</label>
        <input type="text" name="barang_kode" value="{{ $data->barang_kode }}">
        <br>
        <label>Nama Barang</label>
        <input type="text" name="barang_nama" value="{{ $data->barang_nama }}">
        <br>
        <label>ID Kategori</label>
        <input type="number" name="kategori_id" value="{{ $data->kategori_id }}">
        <br>
        <label>Harga Beli</label>
        <input type="number" name="harga_beli" value="{{ $data->harga_beli }}">
        <br>
        <label>Harga Jual</label>
        <input type="number" name="harga_jual" value="{{ $data->harga_jual }}">
        <br>
        <label>Stok</label>
        <input type="number" name="stok" value="{{ $data->stok }}">
        <br>
        <label>ID Supplier</label>
        <input type="number" name="supplier_id" value="{{ $data->supplier_id }}">
        <br><br>
        <input type="submit" class="btn btn-success" value="Ubah">
    </form>
</body>
</html>
