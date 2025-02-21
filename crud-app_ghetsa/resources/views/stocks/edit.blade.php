<!DOCTYPE html>
<html>
<head>
    <title>Edit Stock</title> 
</head>
<body>
    <h1>Edit Stock</h1>

    <!-- Form untuk mengedit data stok -->
    <form action="{{ route('stocks.update', $stock) }}" method="POST">
        @csrf <!-- Token CSRF untuk keamanan -->
        @method('PUT') <!-- Menggunakan metode PUT untuk update data -->

        <!-- Input untuk nama stok -->
        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ $stock->name }}" required>
        <br>

        <!-- Input untuk deskripsi stok -->
        <label for="description">Description:</label>
        <textarea name="description" required>{{ $stock->description }}</textarea>
        <br>

        <!-- Tombol untuk menyimpan perubahan -->
        <button type="submit">Update Stock</button>
    </form>

    <!-- Link untuk kembali ke daftar stok -->
    <a href="{{ route('stocks.index') }}">Back to List</a>
</body>
</html>
