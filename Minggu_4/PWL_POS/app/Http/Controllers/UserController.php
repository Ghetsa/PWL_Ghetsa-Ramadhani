<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {

        // =============================================
        // JOBSHEET 4
        // =============================================
        // PRAKTIKUM 1
        // ---------------------------------------------
        // Praktikum 1 - Langkah 2
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_dua',
        //     'nama' => 'Manager 2',
        //     'password' => Hash::make('12345')
        // ];
        // UserModel::create($data);

        // $user = UserModel::all();
        // return view('user', ['data' => $user]);

        // ---------------------------------------------
        // Praktikum 1 - Langkah 5
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_tiga',
        //     'nama' => 'Manager 3',
        //     'password' => Hash::make('12345')
        // ];
        // UserModel::create($data);

        // $user = UserModel::all();
        // return view('user', ['data' => $user]);

        // ---------------------------------------------
        // PRAKTIKUM 2
        // ---------------------------------------------
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
        // $user = UserModel::where('username', 'manager9')->firstOrFail();
        // return view('user', ['data' => $user]);

        // ---------------------------------------------
        // Praktikum 2.3 - Langkah 1
        // $user = UserModel::where('level_id', 2)->count();
        // dd($user);
        // return view('user', ['data' => $user]);

        // ---------------------------------------------
        // Praktikum 2.2 - Langkah 3
        $user = UserModel::where('level_id', 2)->count();
        return view('user', ['data' => $user]);
        




















        // ---------------------------------------------
        // JOBSHEET 3
        // ---------------------------------------------

        // // tambah data user dengan Eloquent Model
        // $data = [
        //     'nama' => 'Pelanggan Pertama',
        // ];
        // UserModel::where('username', 'customer-1')->update($data); // update data user

        // // coba akses model UserModel
        // $user = UserModel::all(); // ambil semua data dari tabel m_user
        // return view('user', ['data' => $user]);
    }
}