<!DOCTYPE html>
<html>
<head>
    <title>Data Level</title>
</head>
<body>
    <h1>Form Ubah Data Level</h1>
    <a href="/level">Kembali</a>
    <br><br>
    <form method="post" action="/level/ubah_simpan/{{ $data->level_id }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <label>Kode Level</label>
        <input type="text" name="level_kode" value="{{ $data->level_kode }}">
        <br>
        <label>Nama Level</label>
        <input type="text" name="level_nama" value="{{ $data->level_nama }}">
        <br><br>
        <input type="submit" class="btn btn-success" value="Ubah">
    </form>
</body>
</html>