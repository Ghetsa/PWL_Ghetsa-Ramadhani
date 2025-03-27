<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    // public function foodBeverage()
    // {
    //     return view('products.food-beverage');
    // }

    // public function beautyHealth()
    // {
    //     return view('products.beauty-health');
    // }

    // public function homeCare()
    // {
    //     return view('products.home-care');
    // }

    // public function babyKid()
    // {
    //     return view('products.baby-kid');
    // }


    // =============================================
    // JOBSHEET 5 - TUGAS
    // =============================================

    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list' => ['Home', 'Barang']
        ];

        $page = (object) [
            'title' => 'Daftar barang yang tersedia dalam sistem'
        ];

        $activeMenu = 'barang';

        // Ambil semua kategori dari database
        $kategori = KategoriModel::all();

        return view('barang.index', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    // public function list(Request $request)
    // {
    //     $barang = BarangModel::with('kategori');

    //     return DataTables::of($barang)
    //         ->addIndexColumn()
    //         ->addColumn('kategori_nama', function ($barang) {
    //             return $barang->kategori ? $barang->kategori->kategori_nama : '-';
    //         })
    //         ->addColumn('aksi', function ($barang) {
    //             return '
    //                     <a href="' . url('/barang/' . $barang->barang_id) . '" class="btn btn-info btn-sm">Detail</a> 
    //                     <a href="' . url('/barang/' . $barang->barang_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> 
    //                     <form class="d-inline-block" method="POST" action="' . url('/barang/' . $barang->barang_id) . '">
    //                         ' . csrf_field() . method_field('DELETE') . '
    //                         <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\')">Hapus</button>
    //                     </form>';
    //         })
    //         ->rawColumns(['aksi'])
    //         ->make(true);
    // }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Barang',
            'list' => ['Home', 'Barang', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah barang baru'
        ];

        $activeMenu = 'barang';
        $kategori = KategoriModel::all();

        return view('barang.create', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kategori_id' => 'required|integer|exists:m_kategori,kategori_id',
            'barang_kode' => 'required|string|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|max:255',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0'
        ]);

        BarangModel::create($validatedData);

        return redirect('/barang')->with('success', 'Data barang berhasil disimpan');
    }

    public function show($id)
    {
        $barang = BarangModel::with('kategori')->find($id);

        if (!$barang) {
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Detail Barang',
            'list' => ['Home', 'Barang', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail data barang'
        ];

        $activeMenu = 'barang';

        return view('barang.show', compact('breadcrumb', 'page', 'barang', 'activeMenu'));
    }

    public function edit($id)
    {
        $barang = BarangModel::find($id);
        if (!$barang) {
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Edit Barang',
            'list' => ['Home', 'Barang', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit data barang'
        ];

        $activeMenu = 'barang';
        $kategori = KategoriModel::all();

        return view('barang.edit', compact('breadcrumb', 'page', 'activeMenu', 'barang', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $barang = BarangModel::find($id);
        if (!$barang) {
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }

        $validatedData = $request->validate([
            'kategori_id' => 'required|integer|exists:m_kategori,kategori_id',
            'barang_kode' => 'required|string|unique:m_barang,barang_kode,' . $id . ',barang_id',
            'barang_nama' => 'required|string|max:255',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0'
        ]);

        $barang->update($validatedData);

        return redirect('/barang')->with('success', 'Data barang berhasil diperbarui');
    }

    public function destroy($id)
    {
        $check = BarangModel::find($id);

        if (!$check) {
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }

        try {
            BarangModel::destroy($id);
            return redirect('/barang')->with('success', 'Data barang berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/barang')->with('error', 'Gagal menghapus data barang karena data masih terhubung dengan tabel lain');
        }
    }


    // =============================================
    // JOBSHEET 6
    // =============================================
    // Praktikum 1 - Langkah 7
    public function create_ajax()
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();
        return view('barang.create_ajax')->with('kategori', $kategori);
    }
    // Praktikum 1 - Langkah 9
    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id' => 'required|integer',
                'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode',
                'barang_nama' => 'required|string|max:100',
                'harga_beli' => 'required|integer|max:10000000',
                'harga_jual' => 'required|integer|max:10000000'

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors() // pesan error validasi
                ]);
            }

            BarangModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data barang berhasil disimpan'
            ]);
        }

        redirect('/');
    }


    // Praktikum 2 - Langkah 2
    // Ambil data barang dalam bentuk json untuk datatables
    public function list()
    {
        $barang = BarangModel::with('kategori')->select('barang_id', 'kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual');

        return DataTables::of($barang)
            ->addIndexColumn()
            ->addColumn('kategori_nama', function ($barang) {
                return $barang->kategori->kategori_nama ?? '-';
            })
            ->addColumn('aksi', function ($barang) {
                // $btn  = '<a href="' . url('/barang/' . $barang->barang_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="' . url('/barang/' . $barang->barang_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/barang/' . $barang->barang_id) . '">'
                //       . csrf_field()
                //       . method_field('DELETE')
                //       . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus?\')">Hapus</button>'
                //       . '</form>';
                // return $btn;
                $btn = '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // Praktikum 2 - Langkah 4
    // Menampilkan halaman form edit barang ajax
    public function edit_ajax(string $id)
    {
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();

        return view('barang.edit_ajax', [
            'barang' => $barang,
            'kategori' => $kategori,
        ]);
    }

    // Praktikum 2 - Langkah 6
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id' => 'required|integer|exists:m_kategori,kategori_id',
                'barang_kode' => 'required|string|unique:m_barang,barang_kode,' . $id . ',barang_id',
                'barang_nama' => 'required|string|max:100',
                'harga_beli' => 'required|numeric|min:0',
                'harga_jual' => 'required|numeric|min:0',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors(),
                ]);
            }

            $barang = BarangModel::find($id);
            if ($barang) {
                $barang->update($request->all());

                return response()->json([
                    'status' => true,
                    'message' => 'Data barang berhasil diupdate.',
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan.',
            ]);
        }

        return redirect('/');
    }


    // Praktikum 3 - Langkah 3
    public function confirm_ajax(string $id)
    {
        $barang = BarangModel::find($id);
        return view('barang.confirm_ajax', ['barang' => $barang]);
    }
    // Praktikum 3 - Langkah 5

    // Hapus data barang
    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $barang = BarangModel::find($id);
            if ($barang) {
                $barang->delete();

                return response()->json([
                    'status'  => true,
                    'message' => 'Data barang berhasil dihapus.',
                ]);
            }

            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan.',
            ]);
        }

        return redirect('/');
    }


}


