<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\StokModel;
use App\Models\PenjualanModel;
use App\Models\KategoriModel;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'dashboard';

        $totalKategori = KategoriModel::count('kategori_id');
        $totalBarang = BarangModel::count();
        $totalStok = DB::table('t_stok')->sum('stok_jumlah');
        $totalPenjualan = PenjualanModel::sum('total_bayar');

        $penjualanTerbaru = PenjualanModel::orderBy('penjualan_tanggal', 'desc')
        ->limit(10)
        ->get();


        return view('welcome', compact(
            'breadcrumb',
            'activeMenu',
            'totalKategori',
            'totalBarang',
            'totalStok',
            'totalPenjualan',
            'penjualanTerbaru'
        ));
    }
}
