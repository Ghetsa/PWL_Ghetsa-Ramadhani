<?php

namespace App\Http\Controllers;

use App\Models\StokModel;
use App\Models\BarangModel;
use App\Models\SupplierModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
  // public function index()
  // {
  // ============================
  // | JOBSHEET 3 - PRAKTIKUM 4 |
  // ============================
  // DB::insert('insert into t_stok(barang_id, user_id, supplier_id, stok_tanggal_masuk, stok_jumlah, created_at) values(?, ?, ?, ?, ?, ?)', [10, 1, 1, now(), 100, now()]);
  // return 'Insert data baru berhasil';

  // $row = DB::update('update t_stok set stok_jumlah = ? where stok_id = ?', [15, 10]);
  // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

  // $row = DB::delete('delete from t_stok where stok_id = ?', [10]);
  // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

  // $data = DB::select('select * from t_stok');
  // return view('stok', ['data' => $data]);

  // ============================
  // | JOBSHEET 4 - PRAKTIKUM 1 |
  // ============================
  //       $data = [
  //         'barang_id' => 13,
  //         'supplier_id' => 1,
  //         'user_id' => 1,
  //         'stok_tanggal' => now(),
  //         'stok_jumlah' => 50
  //     ];
  //     StokModel::insert($data);

  //     $stok = StokModel::all();
  //     return view('stok', ['data' => $stok]);
  // }

  // public function index()
  // {
  //   $stok = StokModel::all(); // Ambil semua data dari tabel t_stok
  //   return view('stok', ['data' => $stok]);
  // }

  // public function tambah()
  // {
  //   return view('stok_tambah');
  // }

  // public function tambah_simpan(Request $request)
  // {
  //   StokModel::create([
  //     'barang_id' => $request->barang_id,
  //     'user_id' => $request->user_id,
  //     'stok_tanggal' => $request->stok_tanggal,
  //     'stok_jumlah' => $request->stok_jumlah,
  //   ]);

  //   return redirect('/stok');
  // }

  // public function ubah($id)
  // {
  //   $stok = StokModel::find($id);
  //   return view('stok_ubah', ['data' => $stok]);
  // }

  // public function ubah_simpan($id, Request $request)
  // {
  //   $stok = StokModel::find($id);

  //   $stok->barang_id = $request->barang_id;
  //   $stok->user_id = $request->user_id;
  //   $stok->stok_tanggal = $request->stok_tanggal;
  //   $stok->stok_jumlah = $request->stok_jumlah;

  //   $stok->save();

  //   return redirect('/stok');
  // }

  // public function hapus($id)
  // {
  //   $stok = StokModel::find($id);
  //   $stok->delete();

  //   return redirect('/stok');
  // }

  // =============================================
  // JOBSHEET 5 - TUGAS
  // =============================================

  public function index()
  {
    $breadcrumb = (object) [
      'title' => 'Data Stok',
      'list' => ['Home', 'Stok']
    ];

    $page = (object) [
      'title' => 'Daftar data stok barang'
    ];

    $activeMenu = 'stok';

    $barang = BarangModel::all(); // untuk filter barang

    return view('stok.index', compact('breadcrumb', 'page', 'activeMenu', 'barang'));
  }

  public function list(Request $request)
  {
    $stok = StokModel::with(['barang', 'user', 'supplier']);
    if ($request->barang_id) {
      $stok->where('barang_id', $request->barang_id);
    }

    return DataTables::of($stok)
      ->addIndexColumn()
      ->addColumn('aksi', function ($s) {
        $btn = '<a href="' . url('/stok/' . $s->stok_id) . '" class="btn btn-info btn-sm">Detail</a> ';
        $btn .= '<a href="' . url('/stok/' . $s->stok_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
        $btn .= '<form class="d-inline-block" method="POST" action="' . url('/stok/' . $s->stok_id) . '">'
          . csrf_field()
          . method_field('DELETE')
          . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus data ini?\');">Hapus</button>'
          . '</form>';
        return $btn;
      })
      ->rawColumns(['aksi'])
      ->make(true);
  }

  public function create()
  {
    $breadcrumb = (object) [
      'title' => 'Tambah Stok',
      'list' => ['Home', 'Stok', 'Tambah']
    ];

    $page = (object) [
      'title' => 'Tambah data stok baru'
    ];

    $barang = BarangModel::all();
    $user = UserModel::all();
    $supplier = SupplierModel::all(); // Tambahkan supplier
    $activeMenu = 'stok';

    return view('stok.create', compact('breadcrumb', 'page', 'barang', 'user', 'supplier', 'activeMenu'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'barang_id' => 'required|integer',
      'user_id' => 'required|integer',
      'supplier_id' => 'required|integer',
      'stok_tanggal' => 'required|date',
      'stok_jumlah' => 'required|integer|min:1',
    ]);

    StokModel::create($request->all());

    return redirect('/stok')->with('success', 'Data stok berhasil disimpan');
  }

  public function show($id)
  {
    $stok = StokModel::with(['barang', 'user', 'supplier'])->find($id);

    $breadcrumb = (object) [
      'title' => 'Detail Stok',
      'list' => ['Home', 'Stok', 'Detail']
    ];

    $page = (object) [
      'title' => 'Detail data stok'
    ];

    $activeMenu = 'stok';

    return view('stok.show', compact('breadcrumb', 'page', 'stok', 'activeMenu'));
  }

  public function edit($id)
  {
    $stok = StokModel::find($id);
    $barang = BarangModel::all();
    $user = UserModel::all();
    $supplier = SupplierModel::all(); // Tambahkan supplier

    $breadcrumb = (object) [
      'title' => 'Edit Stok',
      'list' => ['Home', 'Stok', 'Edit']
    ];

    $page = (object) [
      'title' => 'Edit data stok'
    ];

    $activeMenu = 'stok';

    return view('stok.edit', compact('breadcrumb', 'page', 'stok', 'barang', 'user', 'supplier', 'activeMenu'));
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'barang_id' => 'required|integer',
      'user_id' => 'required|integer',
      'supplier_id' => 'required|integer',
      'stok_tanggal' => 'required|date',
      'stok_jumlah' => 'required|integer|min:1',
    ]);

    StokModel::find($id)->update($request->all());

    return redirect('/stok')->with('success', 'Data stok berhasil diubah');
  }

  public function destroy($id)
  {
    $check = StokModel::find($id);

    if (!$check) {
      return redirect('/stok')->with('error', 'Data stok tidak ditemukan');
    }

    try {
      StokModel::destroy($id);
      return redirect('/stok')->with('success', 'Data stok berhasil dihapus');
    } catch (\Illuminate\Database\QueryException $e) {
      return redirect('/stok')->with('error', 'Gagal menghapus data stok karena data masih terhubung dengan tabel lain');
    }
  }
}