<!DOCTYPE html>
<html>
<head>
    <title>Stock List</title> 
</head>
<body>
    <h1>Stocks</h1> 

    <!-- Menampilkan pesan sukses -->
    @if(session('success'))
        <p>{{ session('success') }}</p> 
    @endif

    <!-- Link untuk menambahkan stock baru -->
    <a href="{{ route('stocks.create') }}">Add Stock</a>

    <ul>
        <!-- Melakukan perulangan untuk setiap stock -->
        @foreach($stocks as $stock)
            <li>
                <!-- Menampilkan nama stock -->
                {{ $stock->name }} - 

                <!-- Link untuk mengedit stock -->
                <a href="{{ route('stocks.edit', $stock) }}">Edit</a>

                <!-- Form untuk menghapus stock -->
                <form action="{{ route('stocks.destroy', $stock) }}" method="POST" style="display:inline;">
                    @csrf <!-- Token CSRF untuk keamanan -->
                    @method('DELETE') <!-- Menggunakan metode DELETE untuk penghapusan -->
                    <button type="submit">Delete</button> <!-- Tombol untuk menghapus stock -->
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
