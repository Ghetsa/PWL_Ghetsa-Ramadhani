<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{

  public function index()
  {
    $breadcrumb = (object) [
      'title' => 'Profil Saya',
      'list' => ['Home', 'Profil']
    ];
    return view('profile.index', [
      'activeMenu' => 'profile' // atau sesuaikan dengan nama menu-nya
    ], compact('breadcrumb'));
  }

  public function edit()
  {
    $breadcrumb = (object) [
      'title' => 'Edit Profil',
      'list' => ['Home', 'Profil', 'Edit']
    ];
    $level = LevelModel::all();

    return view('profile.edit', [
      'activeMenu' => 'profile'
    ], compact('breadcrumb', 'level'));
  }


  public function updateFoto(Request $request)
  {
    $request->validate([
      'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    $user = Auth::user();

    // Hapus foto lama jika ada
    if ($user->foto && Storage::disk('public')->exists('foto_profil/' . $user->foto)) {
      Storage::disk('public')->delete('foto_profil/' . $user->foto);
    }

    // Simpan foto baru
    $file = $request->file('foto');
    $filename = uniqid() . '.' . $file->getClientOriginalExtension();
    $file->storeAs('foto_profil', $filename, 'public');

    $user->foto = $filename;
    $user->save();

    return redirect()->back()->with('success', 'Foto profil berhasil diubah.');
  }

  public function update(Request $request)
  {
    $user = Auth::user();

    $request->validate([
      'nama' => 'required|string|max:255',
      'username' => 'required|string|max:255|unique:m_user,username,' . $user->user_id . ',user_id',
      'password_lama' => 'nullable|string',
      'password_baru' => 'nullable|string|min:6|confirmed',
      'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Update nama dan username
    $user->nama = $request->nama;
    $user->username = $request->username;

    // Cek dan update password jika dimasukkan
    if ($request->filled('password_lama') && $request->filled('password_baru')) {
      if (Hash::check($request->password_lama, $user->password)) {
        $user->password = bcrypt($request->password_baru);
      } else {
        return back()->withErrors(['password_lama' => 'Password lama tidak sesuai.']);
      }
    }

    // Cek dan simpan foto jika ada
    if ($request->hasFile('foto')) {
      if ($user->foto && Storage::disk('public')->exists('foto_profil/' . $user->foto)) {
        Storage::disk('public')->delete('foto_profil/' . $user->foto);
      }

      $file = $request->file('foto');
      $filename = uniqid() . '.' . $file->getClientOriginalExtension();
      $file->storeAs('foto_profil', $filename, 'public');
      $user->foto = $filename;
    }
    $user->save();
    return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
  }

}