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
        // Praktikum 2.4 - Langkah 6
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
        // $user = UserModel::where(
        //     [
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
        // Praktikum 2.5 - Langkah 4
        $user = UserModel::create([
            'username' => 'manager11',
            'nama' => 'Manager11',
            'password' => Hash::make('12345'),
            'level_id' => 2,
        ]);

        $user->username = 'manager12';

        $user->save();

        $user->wasChanged(); // true
        $user->wasChanged('username'); // true
        $user->wasChanged(['username', 'level_id']); // true
        $user->wasChanged('nama'); // false
        dd($user->wasChanged(['nama', 'username'])); // true

        




















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