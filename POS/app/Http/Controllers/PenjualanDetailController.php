<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PenjualanDetailModel;


class PenjualanDetailController extends Controller
{
  // public function index()
  // {
  // ============================
  // | JOBSHEET 3 - PRAKTIKUM 4 |
  // ============================
  // DB::insert('insert into t_penjualan_detail(penjualan_id, barang_id, jumlah_barang, harga_barang, created_at) values(?, ?, ?, ?, ?)', [11, 11, 7, 180000, now()]);
  // return 'Insert data baru berhasil';

  // $row = DB::update('update t_penjualan_detail set jumlah_barang = ? where detail_id = ?', [3, 12]);
  // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

  // $row = DB::delete('delete from t_penjualan_detail where detail_id = ?', [12]);
  // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

  // $data = DB::select('select * from t_penjualan_detail');
  // return view('penjualan_detail', ['data' => $data]);

  // ============================
  // | JOBSHEET 4 - PRAKTIKUM 1 |
  // ============================
  //       $data = [
  //         'penjualan_id' => 1,
  //         'barang_id' => 1,
  //         'harga' => 650000,
  //         'jumlah' => 1
  //     ];
  //     PenjualanDetailModel::insert($data);

  //     $detail = PenjualanDetailModel::all();
  //     return view('penjualan_detail', ['data' => $detail]);

  // }

  public function index()
  {
    $detail = PenjualanDetailModel::all();
    return view('penjualan_detail', ['data' => $detail]);
  }

  public function tambah()
  {
    return view('penjualan_detail_tambah');
  }

  public function tambah_simpan(Request $request)
  {
    PenjualanDetailModel::create([
      'penjualan_id' => $request->penjualan_id,
      'barang_id' => $request->barang_id,
      'harga' => $request->harga,
      'jumlah' => $request->jumlah,
    ]);

    return redirect('/penjualan-detail');
  }

  public function ubah($id)
  {
    $detail = PenjualanDetailModel::find($id);
    return view('penjualan_detail_ubah', ['data' => $detail]);
  }

  public function ubah_simpan($id, Request $request)
  {
    $detail = PenjualanDetailModel::find($id);

    $detail->penjualan_id = $request->penjualan_id;
    $detail->barang_id = $request->barang_id;
    $detail->harga = $request->harga;
    $detail->jumlah = $request->jumlah;

    $detail->save();

    return redirect('/penjualan-detail');
  }

  public function hapus($id)
  {
    $detail = PenjualanDetailModel::find($id);
    $detail->delete();

    return redirect('/penjualan-detail');
  }
}