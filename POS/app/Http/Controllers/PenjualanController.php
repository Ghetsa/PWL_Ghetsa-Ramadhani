<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PenjualanModel;

class PenjualanController extends Controller
{

  // public function index()
  // {
  // ============================
  // | JOBSHEET 3 - PRAKTIKUM 4 |
  // ============================
  // DB::insert('insert into t_penjualan(user_id, pembeli, penjualan_kode, tanggal_penjualan, created_at) values(?, ?, ?, ?, ?)', [3, 'Ayu Widodo', 'TR011', now(), now()]);
  // return 'Insert data baru berhasil';

  // $row = DB::update('update t_penjualan set pembeli = ? where penjualan_kode = ?', ['Selina Bunga', 'PNJ11']);
  // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

  // $row = DB::delete('delete from t_penjualan where penjualan_kode = ?', ['PNJ11']);
  // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

  // $data = DB::select('select * from t_penjualan');
  // return view('penjualan', ['data' => $data]);

  // ============================
  // | JOBSHEET 4 - PRAKTIKUM 1 |
  // ============================
  //       $data = [
  //         'user_id' => 1,
  //         'pembeli' => 'Andi',
  //         'penjualan_kode' => 'TRX011',
  //         'penjualan_tanggal' => now()
  //     ];
  //     PenjualanModel::insert($data);

  //     $penjualan = PenjualanModel::all();
  //     return view('penjualan', ['data' => $penjualan]);

  // }

  public function index()
  {
    $penjualan = PenjualanModel::all();
    return view('penjualan', ['data' => $penjualan]);
  }

  public function tambah()
  {
    return view('penjualan_tambah');
  }

  public function tambah_simpan(Request $request)
  {
    PenjualanModel::create([
      'user_id' => $request->user_id,
      'pembeli' => $request->pembeli,
      'penjualan_kode' => $request->penjualan_kode,
      'penjualan_tanggal' => $request->penjualan_tanggal,
    ]);

    return redirect('/penjualan');
  }

  public function ubah($id)
  {
    $penjualan = PenjualanModel::find($id);
    return view('penjualan_ubah', ['data' => $penjualan]);
  }

  public function ubah_simpan($id, Request $request)
  {
    $penjualan = PenjualanModel::find($id);

    $penjualan->user_id = $request->user_id;
    $penjualan->pembeli = $request->pembeli;
    $penjualan->penjualan_kode = $request->penjualan_kode;
    $penjualan->penjualan_tanggal = $request->penjualan_tanggal;

    $penjualan->save();

    return redirect('/penjualan');
  }

  public function hapus($id)
  {
    $penjualan = PenjualanModel::find($id);
    $penjualan->delete();

    return redirect('/penjualan');
  }
}