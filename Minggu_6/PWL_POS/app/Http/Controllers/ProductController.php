<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use Yajra\DataTables\Facades\DataTables;

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

        // Ambil semua kategori dari database untuk filter
        $kategori = KategoriModel::all();

        return view('barang.index', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    public function list(Request $request)
    {
        // Ambil barang dan relasi dengan kategori
        $barang = BarangModel::with('kategori');

        // Jika ada filter kategori_id yang dipilih, terapkan filter
        if ($request->has('kategori_id') && !empty($request->kategori_id)) {
            $barang->where('kategori_id', $request->kategori_id);
        }

        return DataTables::of($barang)
            ->addIndexColumn()
            ->addColumn('kategori_nama', function ($barang) {
                return $barang->kategori ? $barang->kategori->kategori_nama : '-';
            })
            ->addColumn('aksi', function ($barang) {
                return '
                        <a href="' . url('/barang/' . $barang->barang_id) . '" class="btn btn-info btn-sm">Detail</a> 
                        <a href="' . url('/barang/' . $barang->barang_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> 
                        <form class="d-inline-block" method="POST" action="' . url('/barang/' . $barang->barang_id) . '">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\')">Hapus</button>
                        </form>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}
