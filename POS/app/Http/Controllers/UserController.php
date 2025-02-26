<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // public function show($id, $name)
    // {
    //     return view('user.profile', compact('id', 'name'));
    // }


    // public function profile()
    // {
    //     $user = Auth::user(); // Mendapatkan user yang sedang login

    //     return view('user.profile', compact('user')); // Kirim ke view
    // }
    public function profile($id)
    {
        // Ambil data user berdasarkan ID
        $user = User::find($id);

        // Periksa apakah user ditemukan
        if (!$user) {
            return abort(404, 'User tidak ditemukan');
        }

        return view('user.profile', compact('user'));
    }

}
