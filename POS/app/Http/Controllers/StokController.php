<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\StokModel;

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

  public function index()
  {
    $stok = StokModel::all(); // Ambil semua data dari tabel t_stok
    return view('stok', ['data' => $stok]);
  }

  public function tambah()
  {
    return view('stok_tambah');
  }

  public function tambah_simpan(Request $request)
  {
    StokModel::create([
      'barang_id' => $request->barang_id,
      'user_id' => $request->user_id,
      'stok_tanggal' => $request->stok_tanggal,
      'stok_jumlah' => $request->stok_jumlah,
    ]);

    return redirect('/stok');
  }

  public function ubah($id)
  {
    $stok = StokModel::find($id);
    return view('stok_ubah', ['data' => $stok]);
  }

  public function ubah_simpan($id, Request $request)
  {
    $stok = StokModel::find($id);

    $stok->barang_id = $request->barang_id;
    $stok->user_id = $request->user_id;
    $stok->stok_tanggal = $request->stok_tanggal;
    $stok->stok_jumlah = $request->stok_jumlah;

    $stok->save();

    return redirect('/stok');
  }

  public function hapus($id)
  {
    $stok = StokModel::find($id);
    $stok->delete();

    return redirect('/stok');
  }
}