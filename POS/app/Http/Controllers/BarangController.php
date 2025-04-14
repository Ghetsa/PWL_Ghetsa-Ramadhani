<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
  // public function index()
  // {
  // ============================
  // | JOBSHEET 3 - PRAKTIKUM 4 |
  // ============================
  // DB::insert('insert into m_barang(kategori_id, barang_kode, barang_nama, harga_jual, harga_beli, created_at) values(?, ?, ?, ?, ?, ?)', [1, 'BABY003', 'Dot Bayi', 15000, 10000, now()]);
  // return 'Insert data baru berhasil';

  // $row = DB::update('update m_barang set harga_jual = ? where barang_kode = ?', [17000, 'BABY003']);
  // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

  // $row = DB::delete('delete from m_barang where barang_kode = ?', ['BABY003']);
  // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

  // $data = DB::select('select * from m_barang');
  // return view('barang', ['data' => $data]);


  // ============================
  // | JOBSHEET 4 - PRAKTIKUM 1 |
  // ============================
  //   $data = [
  //     'kategori_id' => 5,
  //     'barang_kode' => 'ELECT003',
  //     'barang_nama' => 'Laptop ASUS',
  //     'harga_beli' => 5000000,
  //     'harga_jual' => 6500000
  // ];
  // BarangModel::insert($data);

  // $barang = BarangModel::all();
  // return view('barang', ['data' => $barang]);

  // }
  // public function index()
  // {
  //   $barang = BarangModel::all(); // ambil semua data dari tabel t_barang
  //   return view('barang', ['data' => $barang]);
  // }

  // public function tambah()
  // {
  //   return view('barang_tambah');
  // }

  // public function tambah_simpan(Request $request)
  // {
  //   BarangModel::create([
  //     'kategori_id' => $request->kategori_id,
  //     'barang_kode' => $request->barang_kode,
  //     'barang_nama' => $request->barang_nama,
  //     'harga_beli' => $request->harga_beli,
  //     'harga_jual' => $request->harga_jual
  //   ]);

  //   return redirect('/barang');
  // }

  // public function ubah($id)
  // {
  //   $barang = BarangModel::find($id);
  //   return view('barang_ubah', ['data' => $barang]);
  // }

  // public function ubah_simpan($id, Request $request)
  // {
  //   $barang = BarangModel::find($id);

  //   $barang->kategori_id = $request->kategori_id;
  //   $barang->barang_kode = $request->barang_kode;
  //   $barang->barang_nama = $request->barang_nama;
  //   $barang->harga_beli = $request->harga_beli;
  //   $barang->harga_jual = $request->harga_jual;

  //   $barang->save();

  //   return redirect('/barang');
  // }

  // public function hapus($id)
  // {
  //   $barang = BarangModel::find($id);
  //   $barang->delete();

  //   return redirect('/barang');
  // }

  // =============================================
    // JOBSHEET 5 - TUGAS
    // =============================================

    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list' => ['Home', 'Barang']
        ];

        $page = (object) [
            'title' => 'Daftar barang yang tersedia dalam sistem'
        ];

        $activeMenu = 'barang';

        // Ambil semua kategori dari database
        $kategori = KategoriModel::all();

        return view('barang.index', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    public function list(Request $request)
    {
        $barang = BarangModel::with('kategori');

        return DataTables::of($barang)
            ->addIndexColumn()
            ->addColumn('kategori_nama', function ($barang) {
                return $barang->kategori ? $barang->kategori->kategori_nama : '-';
            })
            ->addColumn('aksi', function ($barang) {
                return '
                        <a href="' . url('/barang/' . $barang->barang_id) . '" class="btn btn-info btn-sm">Detail</a> 
                        <a href="' . url('/barang/' . $barang->barang_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> 
                        <form class="d-inline-block" method="POST" action="' . url('/barang/' . $barang->barang_id) . '">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\')">Hapus</button>
                        </form>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Barang',
            'list' => ['Home', 'Barang', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah barang baru'
        ];

        $activeMenu = 'barang';
        $kategori = KategoriModel::all();

        return view('barang.create', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kategori_id' => 'required|integer|exists:m_kategori,kategori_id',
            'barang_kode' => 'required|string|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|max:255',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0'
        ]);

        BarangModel::create($validatedData);

        return redirect('/barang')->with('success', 'Data barang berhasil disimpan');
    }

    public function show($id)
    {
        $barang = BarangModel::with('kategori')->find($id);

        if (!$barang) {
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Detail Barang',
            'list' => ['Home', 'Barang', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail data barang'
        ];

        $activeMenu = 'barang';

        return view('barang.show', compact('breadcrumb', 'page', 'barang', 'activeMenu'));
    }

    public function edit($id)
    {
        $barang = BarangModel::find($id);
        if (!$barang) {
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Edit Barang',
            'list' => ['Home', 'Barang', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit data barang'
        ];

        $activeMenu = 'barang';
        $kategori = KategoriModel::all();

        return view('barang.edit', compact('breadcrumb', 'page', 'activeMenu', 'barang', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $barang = BarangModel::find($id);
        if (!$barang) {
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }

        $validatedData = $request->validate([
            'kategori_id' => 'required|integer|exists:m_kategori,kategori_id',
            'barang_kode' => 'required|string|unique:m_barang,barang_kode,' . $id . ',barang_id',
            'barang_nama' => 'required|string|max:255',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0'
        ]);

        $barang->update($validatedData);

        return redirect('/barang')->with('success', 'Data barang berhasil diperbarui');
    }

    public function destroy($id)
    {
        $barang = BarangModel::find($id);
    
        if (!$barang) {
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }
    
        try {
            // Hapus semua data yang terkait dengan barang ini
            \DB::table('t_penjualan_detail')->where('barang_id', $id)->delete();
    
            // Setelah data terkait dihapus, hapus barang utama
            $barang->delete();
    
            return redirect('/barang')->with('success', 'Data barang berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/barang')->with('error', 'Gagal menghapus barang: ' . $e->getMessage());
        }
    }
}