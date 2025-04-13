<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
  public function index()
  {
    // ============================
    // | JOBSHEET 3 - PRAKTIKUM 4 |
    // ============================
    // DB::insert('insert into t_stok(barang_id, user_id, supplier_id, stok_tanggal_masuk, stok_jumlah, created_at) values(?, ?, ?, ?, ?, ?)', [10, 1, 1, now(), 100, now()]);
    // return 'Insert data baru berhasil';

    // $row = DB::update('update t_stok set stok_jumlah = ? where stok_id = ?', [15, 10]);
    // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

    // $row = DB::delete('delete from t_stok where stok_id = ?', [10]);
    // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

    $data = DB::select('select * from t_stok');
    return view('stok', ['data' => $data]);
  }
}