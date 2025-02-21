<!DOCTYPE html>
<html>
<head>
    <title>Add Stock</title>
</head>
<body>
    <h1>Add Stock</h1> 

    <!-- Form untuk menambahkan stock baru -->
    <form action="{{ route('stocks.store') }}" method="POST">
        <!-- Token CSRF untuk keamanan -->
        @csrf

        <!-- Label dan input untuk nama stock -->
        <label for="name">Name:</label>
        <input type="text" name="name" required>
        <br>

        <!-- Label dan textarea untuk deskripsi stock -->
        <label for="description">Description:</label>
        <textarea name="description" required></textarea>
        <br>

        <!-- Tombol untuk menambahkan stock -->
        <button type="submit">Add Stock</button>
    </form>

    <!-- Link untuk kembali ke daftar stock -->
    <a href="{{ route('stocks.index') }}">Back to List</a>
</body>
</html>
