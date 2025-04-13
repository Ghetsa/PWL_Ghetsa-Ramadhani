<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
    // $data = [
    //   //  'username' => 'customer-1',
    //   //  'nama' => 'Pelanggan',
    //   //  'password' => Hash::make('12345'),
    //   //  'level_id' => 4
    //   'nama' => 'Pelanggan Pertama',
    // ];
    // //  UserModel::insert($data); // tambahkan data ke tabel m_user
    // UserModel::where('username', 'customer-1')->update($data); // update data user

    // //coba akses model UserModel
    // $user = UserModel::all(); // ambil semua data dari tabel m_user
    // return view('user', ['data' => $user]);


    // ============================
    // | JOBSHEET 4 - PRAKTIKUM 1 |
    // ============================
    // $data = [
    //   'level_id' => 2,
    //   'username' => 'manager2',
    //   'nama' => 'Lily Manager 2',
    //   'password' => Hash::make('manager2')
    // ];
    // UserModel::insert($data);

    // $user = UserModel::all();
    // return view('user', ['data' => $user]);

    // ============================
    // | JOBSHEET 4 - PRAKTIKUM 2 |
    // ============================
    // Praktikum 2.1 - Langkah 1
    // $user = UserModel::find(1);
    // return view('user', ['data' => $user]);

    // ---------------------------------------------
    // Praktikum 2.1 - Langkah 4
    // $user = UserModel::where('level_id', 1)->first();
    // return view('user', ['data' => $user]);

    // ---------------------------------------------
    // Praktikum 2.1 - Langkah 6
    // $user = UserModel::firstWhere('level_id', 1);
    // return view('user', ['data' => $user]);

    // ---------------------------------------------
    // Praktikum 2.1 - Langkah 8
    // $user = UserModel::findOr(1, ['username', 'nama'], function () {
    //     abort(404);
    // });

    // return view('user', ['data' => $user]);

    // ---------------------------------------------
    // Praktikum 2.1 - Langkah 10
    // $user = UserModel::findOr(20, ['username', 'nama'], function () {
    //     abort(404);
    // });

    // ---------------------------------------------
    // Praktikum 2.2 - Langkah 1
    // $user = UserModel::findOrFail(1);
    // return view('user', ['data' => $user]);

    // ---------------------------------------------
    // Praktikum 2.2 - Langkah 3
    // $user = UserModel::where('username', 'manager33')->firstOrFail();
    // return view('user', ['data' => $user]);

    // ---------------------------------------------
    // Praktikum 2.3 - Langkah 1
    // $user = UserModel::where('level_id', 2)->count();
    // dd($user);
    // return view('user', ['data' => $user]);

    // ---------------------------------------------
    // Praktikum 2.3 - Langkah 3
    // $user = UserModel::where('level_id', 2)->count();
    // return view('user', ['data' => $user]);

    // ---------------------------------------------
    // Praktikum 2.4 - Langkah 1
    // $user = UserModel::firstOrCreate(
    //     [
    //         'username' => 'manager',
    //         'nama' => 'Manager',
    //     ]
    // );

    // return view('user', ['data' => $user]);

    // ---------------------------------------------
    // Praktikum 2.4 - Langkah 4
    //         $user = UserModel::firstOrCreate(
    //     [
    //         'username' => 'manager22',
    //         'nama' => 'Manager Dua Dua',
    //         'password' => Hash::make('12345'),
    //         'level_id' => 2
    //     ]
    // );

    // return view('user', ['data' => $user]);

    // ---------------------------------------------
    // Praktikum 2.4 - Langkah 6
    // $user = UserModel::firstOrNew(
    //     [
    //         'username' => 'manager',
    //         'nama' => 'Manager',
    //     ],
    // );

    // return view('user', ['data' => $user]);

    // ---------------------------------------------
    // Praktikum 2.4 - Langkah 8
    // $user = UserModel::firstOrNew(
    //     [
    //         'username' => 'manager33',
    //         'nama' => 'Manager Tiga Tiga',
    //         'password' => Hash::make('12345'),
    //         'level_id' => 2
    //     ]
    // );

    // return view('user', ['data' => $user]);

    // ---------------------------------------------
    // Praktikum 2.4 - Langkah 10
    // $user = UserModel::firstOrNew(
    //   [
    //         'username' => 'manager33',
    //         'nama' => 'Manager Tiga Tiga',
    //         'password' => Hash::make('12345'),
    //         'level_id' => 2
    //     ]
    // );
    // $user->save();
    // return view('user', ['data' => $user]);

    // ---------------------------------------------
    // Praktikum 2.5 - Langkah 1
    // $user = UserModel::create([
    //     'username' => 'manager55',
    //     'nama' => 'Manager55',
    //     'password' => Hash::make('12345'),
    //     'level_id' => 2,
    // ]);

    // $user->username = 'manager56';

    // $user->isDirty(); // true
    // $user->isDirty('username'); // true
    // $user->isDirty('nama'); // false
    // $user->isDirty(['nama', 'username']); // true

    // $user->isClean(); // false
    // $user->isClean('username'); // false
    // $user->isClean('nama'); // true
    // $user->isClean(['nama', 'username']); // false

    // $user->save();

    // $user->isDirty(); // false
    // $user->isClean(); // true
    // dd($user->isDirty());

    // ---------------------------------------------
    // Praktikum 2.5 - Langkah 3
    // $user = UserModel::create([
    //     'username' => 'manager11',
    //     'nama' => 'Manager11',
    //     'password' => Hash::make('12345'),
    //     'level_id' => 2,
    // ]);

    // $user->username = 'manager12';

    // $user->save();

    // $user->wasChanged(); // true
    // $user->wasChanged('username'); // true
    // $user->wasChanged(['username', 'level_id']); // true
    // $user->wasChanged('nama'); // false
    // dd($user->wasChanged(['nama', 'username'])); // true

  }

  public function tambah()
  {
    return view('user_tambah');
  }
  public function tambah_simpan(Request $request)
  {
    UserModel::create([
      'username' => $request->username,
      'nama' => $request->nama,
      'password' => Hash::make('$request->password'),
      'level_id' => $request->level_id
    ]);

    return redirect('/user');
  }
  public function ubah($id)
  {
    $user = UserModel::find($id);
    return view('user_ubah', ['data' => $user]);
  }
  public function ubah_simpan($id, Request $request)
  {
    $user = UserModel::find($id);

    $user->username = $request->username;
    $user->nama = $request->nama;
    $user->password = Hash::make('$request->password');
    $user->level_id = $request->level_id;


    $user->save();

    return redirect('/user');
  }
  public function hapus($id)
  {
    $user = UserModel::find($id);
    $user->delete();

    return redirect('/user');
  }

}

