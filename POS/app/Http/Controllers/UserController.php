<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class UserController extends Controller
{

  public function index()
  {
    // ============================
    // | JOBSHEET 3 - PRAKTIKUM 4 |
    // ============================
    // DB::insert('insert into m_user(level_id, username, nama, password, created_at) values(?, ?, ?, ?, ?)', [3, 'staf1', 'staf pertama', Hash::make('123456'), now()]);
    // return 'Insert data baru berhasil';

    // $row = DB::update('update m_user set username = ? where username = ?', ['kasirSatu', 'kasir1']);
    // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

    // $row = DB::delete('delete from m_user where username = ?', ['kasirSatu']);
    // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

    // $data = DB::select('select * from m_user');
    // return view('user', ['data' => $data]);

    // public function user($id, $name) {
    //         return view('user', compact('id', 'name'));
    // }


    // ============================
    // | JOBSHEET 3 - PRAKTIKUM 5 |
    // ============================
    // tambah data user dengan Eloquent Model
    $data = [
      //  'username' => 'customer-1',
      //  'nama' => 'Pelanggan',
      //  'password' => Hash::make('12345'),
      //  'level_id' => 4
      'nama' => 'Pelanggan Pertama',
    ];
    //  UserModel::insert($data); // tambahkan data ke tabel m_user
    UserModel::where('username', 'customer-1')->update($data); // update data user

    //coba akses model UserModel
    $user = UserModel::all(); // ambil semua data dari tabel m_user
    return view('user', ['data' => $user]);
  }
}

