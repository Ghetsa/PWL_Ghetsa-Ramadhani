<?php
namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\password;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;


class UserController extends Controller
{
    public function index()
    {
        // =============================================
        // JOBSHEET 5
        // =============================================
        // Praktikum 3 - Langkah 4

        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user'; // set menu yang sedang aktif

        $level = LevelModel::all(); // ambil data level untuk filter level

        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    // Praktikum 3 - Langkah 7
    // Ambil data user dalam bentuk JSON untuk DataTables
    // public function list(Request $request)
    // {
    //     $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
    //         ->with('level');

    //     // Filter data user berdasarkan level_id
    //     if ($request->level_id) {
    //         $users->where('level_id', $request->level_id);
    //     }

    //     return DataTables::of($users)
    //         // Menambahkan kolom index / nomor urut (default nama kolom: DT_RowIndex)
    //         ->addIndexColumn()
    //         ->addColumn('aksi', function ($user) { // Menambahkan kolom aksi
    //             $btn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';
    //             $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
    //             $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user/' . $user->user_id) . '">'
    //                 . csrf_field() . method_field('DELETE') .
    //                 '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\')">Hapus</button></form>';
    //             return $btn;
    //         })
    //         ->rawColumns(['aksi']) // Memberitahu bahwa kolom aksi berisi HTML
    //         ->make(true);
    // }






    // Praktikum 3 - Langkah 9
    // Menampilkan halaman form tambah user
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah user baru'
        ];

        $level = LevelModel::all(); // ambil data level untuk ditampilkan di form
        $activeMenu = 'user'; // set menu yang sedang aktif

        return view('user.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    // Praktikum 3 - Langkah 11
    // Menyimpan data user baru
    public function store(Request $request)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_user kolom username
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100', // nama harus diisi, berupa string, dan maksimal 100 karakter
            'password' => 'required|min:5', // password harus diisi dan minimal 5 karakter
            'level_id' => 'required|integer' // level_id harus diisi dan berupa angka
        ]);

        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password), // Pastikan password di-hash
            'level_id' => $request->level_id
        ]);


        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }

    // Praktikum 3 - Langkah 14
    // Menampilkan detail user
    public function show(string $id)
    {
        $user = UserModel::with('level')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail user'
        ];

        $activeMenu = 'user'; // set menu yang sedang aktif

        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    // Praktikum 3 - Langkah 18
    // Menampilkan halaman form edit user
    public function edit(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit user'
        ];

        $activeMenu = 'user'; // set menu yang sedang aktif

        return view('user.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan perubahan data user
    public function update(Request $request, string $id)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter,
            // dan bernilai unik di tabel m_user kolom username kecuali untuk user dengan id yang sedang diedit
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required|string|max:100', // nama harus diisi, berupa string, dan maksimal 100 karakter
            'password' => 'nullable|min:5', // password bisa diisi (minimal 5 karakter) dan bisa tidak diisi
            'level_id' => 'required|integer' // level_id harus diisi dan berupa angka
        ]);

        UserModel::find($id)->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil diubah');
    }

    // Praktikum 3 - Langkah 22
    // Menghapus data user
    public function destroy(string $id)
    {
        $check = UserModel::find($id);
        if (!$check) {  // untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            UserModel::destroy($id);  // Hapus data level

            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }


    // =============================================
    // JOBSHEET 6
    // =============================================
    // Praktikum 1 - Langkah 7
    public function create_ajax()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();
        return view('user.create_ajax')->with('level', $level);
    }
    // Praktikum 1 - Langkah 9
    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|string|min:3|unique:m_user,username',
                'nama' => 'required|string|max:100',
                'password' => 'required|min:5'
            ];


            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors() // pesan error validasi
                ]);
            }

            UserModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan'
            ]);
        }

        redirect('/');
    }


    // Praktikum 2 - Langkah 2
    // Ambil data user dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
            ->with('level');

        // Filter data user berdasarkan level_id
        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
            ->addIndexColumn()  // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($user) {  // menambahkan kolom aksi
    
                /* $btn = '<a href="'.url('/user/' . $user->user_id).'" class="btn btn-info btn-sm">Detail</a> ';
            $btn .= '<a href="'.url('/user/' . $user->user_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
            $btn .= '<form class="d-inline-block" method="POST" action="'. url('/user/'.$user->user_id).'">'
            . csrf_field() . method_field('DELETE') .
            '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';*/
                $btn = '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    // Praktikum 2 - Langkah 4
    // Menampilkan halaman form edit user ajax
    public function edit_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
    }

    // Praktikum 2 - Langkah 6
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
                'nama' => 'required|max:100',
                'password' => 'nullable|min:5|max:20'
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgfield' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }

            $check = UserModel::find($id);
            if ($check) {
                if (!$request->filled('password')) { // jika password tidak diisi, maka hapus dari request
                    $request->request->remove('password');
                }

                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    // Praktikum 3 - Langkah 3
    public function confirm_ajax(string $id)
    {
        $user = UserModel::find($id);

        return view('user.confirm_ajax', ['user' => $user]);
    }


    // Praktikum 3 - Langkah 5
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModel::find($id);
            if ($user) {
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
    public function show_ajax($id)
    {
        $user = UserModel::find($id);

        return view('user.show_ajax', compact('user'));
    }


    // =============================================
    // JOBSHEET 8
    // =============================================
    public function import()
    {
        return view('user.import');
    }
    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = ['file_user' => ['required', 'mimes:xlsx', 'max:5120']];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_user');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);
            $insert = [];

            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        UserModel::create([
                            'level_id' => $value['A'],
                            'username' => $value['B'],
                            'nama' => $value['C'],
                            'password' => $value['D'], // akan otomatis di-hash
                            'created_at' => now()
                        ]);
                    }
                }

                if (count($insert) > 0) {
                    UserModel::insertOrIgnore($insert);
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }

        return redirect('/');
    }



    // Tugas 2
    public function export_excel()
    {
        // ambil data barang yang akan di export
        $user = UserModel::select('user_id', 'level_id', 'username', 'nama', 'password')->orderBy('user_id')->get();

        // load library excel
        // Kemudian kita load library Spreadsheet dan kita tentukan header data pada baris pertama di excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil yang active

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'ID User');
        $sheet->setCellValue('C1', 'Level');
        $sheet->setCellValue('D1', 'Username');
        $sheet->setCellValue('E1', 'Nama');
        $sheet->setCellValue('F1', 'Password');

        $sheet->getStyle('A1:F1')->getFont()->setBold(true); // bold header

        // Selanjutnya, kita looping data yang telah kita dapatkan dari database, kemudian kita masukkan ke dalam cell excel
        $no = 1;
        $baris = 2;
        foreach ($user as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->user_id);
            $sheet->setCellValue('C' . $baris, $value->level->nama_level); // ambil nama level
            $sheet->setCellValue('D' . $baris, $value->username);
            $sheet->setCellValue('E' . $baris, $value->nama);
            $sheet->setCellValue('F' . $baris, $value->password);
            $baris++;
            $no++;
        }


        // Kita set lebar tiap kolom di excel untuk menyesuaikan dengan panjang karakter pada masing-masing kolom
        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size kolom
        }

        // Bagian akhir proses export excel adalah kita set nama sheet, dan proses untuk dapat di download oleh pengguna
        $sheet->setTitle('Data user'); // set title sheet

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data User ' . date('Y-m-d H:i:s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    } // end function export_excel


    // Tugas 3
    public function export_pdf()
    {
        $user = UserModel::select('user_id', 'level_id', 'username', 'nama', 'password')->orderBy('level_id')->with('level')->get();

        $pdf = Pdf::loadView('user.export_pdf', ['user' => $user]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render();

        return $pdf->stream('Data User ' . date('Y-m-d H:i:s') . '.pdf');
    }


    //Tugas 4
    public function updateFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user = Auth::user();

        // Hapus foto lama jika ada
        if ($user->foto && Storage::exists('public/foto_profil/' . $user->foto)) {
            Storage::delete('public/foto_profil/' . $user->foto);
        }

        // Simpan foto baru
        $file = $request->file('foto');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/foto_profil', $filename);

        // Simpan ke database
        $user->foto = $filename;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Foto profil berhasil diperbarui.',
            'foto_url' => asset('storage/foto_profil/' . $filename)
        ]);
    }
}








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


// ============================================
// JOBSHEET 5
// ============================================
// Praktikum 3 - Langkah 4
//   $breadcrumb = (object) [
//     'title' => 'Daftar User',
//     'list' => ['Home', 'User']
//   ];

//   $page = (object) [
//     'title' => 'Daftar user yang terdaftar dalam sistem'
//   ];

//   $activeMenu = 'user'; // set menu yang sedang aktif

//   return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);

// }

// public function tambah()
// {
//   return view('user_tambah');
// }
// public function tambah_simpan(Request $request)
// {
//   UserModel::create([
//     'username' => $request->username,
//     'nama' => $request->nama,
//     'password' => Hash::make('$request->password'),
//     'level_id' => $request->level_id
//   ]);

//   return redirect('/user');
// }
// public function ubah($id)
// {
//   $user = UserModel::find($id);
//   return view('user_ubah', ['data' => $user]);
// }
// public function ubah_simpan($id, Request $request)
// {
//   $user = UserModel::find($id);

//   $user->username = $request->username;
//   $user->nama = $request->nama;
//   $user->password = Hash::make('$request->password');
//   $user->level_id = $request->level_id;


//   $user->save();

//   return redirect('/user');
// }
// public function hapus($id)
// {
//   $user = UserModel::find($id);
//   $user->delete();

//   return redirect('/user');
// }


// // ============================================
// // JOBSHEET 5
// // ============================================
// // Praktikum 3 - Langkah 4

// // Ambil data user dalam bentuk JSON untuk DataTables
// public function list(Request $request)
// {
//   $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
//     ->with('level');

//   return DataTables::of($users)
//     // Menambahkan kolom index / nomor urut (default nama kolom: DT_RowIndex)
//     ->addIndexColumn()
//     ->addColumn('aksi', function ($user) {
//       $btn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';
//       $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
//       $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user/' . $user->user_id) . '">'
//         . csrf_field() . method_field('DELETE')
//         . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\')">Hapus</button></form>';
//       return $btn;
//     })
//     ->rawColumns(['aksi']) // Memberitahu bahwa kolom aksi berisi HTML
//     ->make(true);
// }


// }

