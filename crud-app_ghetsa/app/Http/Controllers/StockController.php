<?php


namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    // Menampilkan semua data stok
    public function index()
    {
        $stocks = Stock::all(); // Mengambil semua data dari tabel stocks
        return view('stocks.index', compact('stocks')); // Mengirim data ke view
    }

    // Menampilkan halaman form untuk menambah stok baru
    public function create()
    {
        return view('stocks.create');
    }

    // Menyimpan data stok baru ke database
    public function store(Request $request)
    {
        // Validasi input, memastikan name dan description tidak kosong
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        // Menyimpan data yang hanya memiliki atribut name dan description
        Stock::create($request->only(['name', 'description']));

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('stocks.index')->with('success', 'Stock added successfully.');
    }

    // Menampilkan detail dari stok tertentu
    public function show(Stock $stock)
    {
        return view('stocks.show', compact('stock'));
    }

    // Menampilkan halaman edit stok
    public function edit(Stock $stock)
    {
        return view('stocks.edit', compact('stock'));
    }

    // Memperbarui data stok yang sudah ada
    public function update(Request $request, Stock $stock)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        // Memperbarui data stok hanya dengan atribut yang diizinkan
        $stock->update($request->only(['name', 'description']));

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('stocks.index')->with('success', 'Stock updated successfully.');
    }

    // Menghapus stok dari database
    public function destroy(Stock $stock)
    {
        $stock->delete(); // Menghapus data stok dari database
        return redirect()->route('stocks.index')->with('success', 'Stock deleted successfully.');
    }
}
