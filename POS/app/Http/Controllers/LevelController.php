<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LevelModel;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
  public function index()
  {
    // ============================
    // | JOBSHEET 3 - PRAKTIKUM 4 |
    // ============================
    // DB::insert('insert into m_level(level_kode, level_nama, created_at) values(?, ?, ?)', ['CUS', 'Pelanggan', now()]);
    // return 'Insert data baru berhasil';

    // $row = DB::update('update m_level set level_nama = ? where level_kode = ?', ['Customer', 'CUS']);
    // return 'Update data berhasil. Jumlah data yang diupdate: ' . $row . ' baris';

    // $row = DB::delete('delete from m_level where level_kode = ?', ['CUS']);
    // return 'Delete data berhasil. Jumlah data yang dihapus: ' . $row . ' baris';

    // $data = DB::select('select * from m_level');
    // return view('level', ['data' => $data]);

    // ============================
    // | JOBSHEET 4 - PRAKTIKUM 1 |
    // ============================
    $data = [
      'level_kode' => 'CSM',
      'level_nama' => 'Customer'
    ];
    LevelModel::insert($data);

    $level = LevelModel::all();
    return view('level', ['data' => $level]);
  }
}
