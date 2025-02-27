<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
</head>

<body>
    <h2>Profil Pengguna</h2>
    <p>Berisikan halaman informasi pengguna</p>
    <hr>
    <p>Nama: {{ $name }}</p>
    <p>ID: {{ $id }}</p>
    {{-- <p>Nama: {{ $user->name }}</p>
    <p>Email: {{ $user->email }}</p> --}}
    <button onclick="window.location.href='../..'">Kembali</button>

</body>

</html>