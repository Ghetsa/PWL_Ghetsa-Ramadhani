<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanDetailModel;
use App\Models\PenjualanModel;
use App\Models\BarangModel;
use Yajra\DataTables\Facades\DataTables;


class PenjualanDetailController extends Controller
{
  // =============================================
  // JOBSHEET 5 - TUGAS
  // =============================================
  public function index($penjualan_id)
  {
    $breadcrumb = (object) [
      'title' => 'Data Detail Penjualan',
      'list' => ['Home', 'Penjualan', 'Detail']
    ];

    $page = (object) [
      'title' => 'Daftar data detail penjualan'
    ];

    $activeMenu = 'penjualan';

    $penjualan = PenjualanModel::findOrFail($penjualan_id);
    $barang = BarangModel::all();

    return view('penjualandetail.index', compact('breadcrumb', 'page', 'activeMenu', 'penjualan', 'barang'));
  }

  public function list($penjualan_id)
  {
    $detail = PenjualanDetailModel::with(['barang'])
      ->where('penjualan_id', $penjualan_id);

    return DataTables::of($detail)
      ->addIndexColumn()
      ->addColumn('aksi', function ($d) use ($penjualan_id) {
        $btn = '<a href="' . url("/penjualan/$penjualan_id/detail/$d->detail_id/edit") . '" class="btn btn-warning btn-sm">Edit</a> ';
        $btn .= '<form class="d-inline-block" method="POST" action="' . url("/penjualan/$penjualan_id/detail/$d->detail_id") . '">'
          . csrf_field()
          . method_field('DELETE') .
          '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus data ini?\');">Hapus</button>' .
          '</form>';
        return $btn;
      })
      ->rawColumns(['aksi'])
      ->make(true);
  }

  public function create($penjualan_id)
  {
    $breadcrumb = (object) [
      'title' => 'Tambah Detail Penjualan',
      'list' => ['Home', 'Penjualan', 'Detail', 'Tambah']
    ];

    $page = (object) [
      'title' => 'Tambah detail penjualan'
    ];

    $activeMenu = 'penjualan';

    $penjualan = PenjualanModel::findOrFail($penjualan_id);
    $barang = BarangModel::all();

    return view('penjualandetail.create', compact('breadcrumb', 'page', 'activeMenu', 'penjualan', 'barang'));
  }

  public function store(Request $request, $penjualan_id)
  {
    $request->validate([
      'barang_id' => 'required|integer',
      'jumlah' => 'required|integer|min:1',
      'harga' => 'required|numeric|min:0',
    ]);

    $request['penjualan_id'] = $penjualan_id;
    PenjualanDetailModel::create($request->all());

    return redirect("/penjualan/$penjualan_id")->with('success', 'Detail penjualan berhasil ditambahkan');
  }

  public function edit($penjualan_id, $id)
  {
    $detail = PenjualanDetailModel::findOrFail($id);
    $barang = BarangModel::all();
    $penjualan = PenjualanModel::findOrFail($penjualan_id);

    $breadcrumb = (object) [
      'title' => 'Edit Detail Penjualan',
      'list' => ['Home', 'Penjualan', 'Detail', 'Edit']
    ];

    $page = (object) [
      'title' => 'Edit detail penjualan'
    ];

    $activeMenu = 'penjualan';

    return view('penjualandetail.edit', compact('breadcrumb', 'page', 'activeMenu', 'penjualan', 'barang', 'detail'));
  }

  public function update(Request $request, $penjualan_id, $id)
  {
    $request->validate([
      'barang_id' => 'required|integer',
      'jumlah' => 'required|integer|min:1',
      'harga' => 'required|numeric|min:0',
    ]);

    $detail = PenjualanDetailModel::findOrFail($id);
    $detail->update($request->all());

    return redirect("/penjualan/$penjualan_id")->with('success', 'Detail penjualan berhasil diubah');
  }

  public function destroy($penjualan_id, $id)
  {
    $check = PenjualanDetailModel::find($id);

    if (!$check) {
      return redirect("/penjualan/$penjualan_id")->with('error', 'Data detail penjualan tidak ditemukan');
    }

    try {
      PenjualanDetailModel::destroy($id);
      return redirect("/penjualan/$penjualan_id")->with('success', 'Detail penjualan berhasil dihapus');
    } catch (\Illuminate\Database\QueryException $e) {
      return redirect("/penjualan/$penjualan_id")->with('error', 'Gagal menghapus detail karena masih terhubung dengan data lain');
    }
  }
  // public function index()
  // {
  // ============================
  // | JOBSHEET 3 - PRAKTIKUM 4 |
  // ============================
  // DB::insert('insert into t_penjualan_detail(penjualan_id, barang_id, jumlah_barang, harga_barang, created_at) values(?, ?, ?, ?, ?)', [11, 11, 7, 180000, now()]);
  // return 'Insert data baru berhasil';

  // $row = DB::update('update t_penjualan_detail set jumlah_barang = ? where detail_id = ?', [3, 12]);
  // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

  // $row = DB::delete('delete from t_penjualan_detail where detail_id = ?', [12]);
  // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

  // $data = DB::select('select * from t_penjualan_detail');
  // return view('penjualan_detail', ['data' => $data]);

  // ============================
  // | JOBSHEET 4 - PRAKTIKUM 1 |
  // ============================
  //       $data = [
  //         'penjualan_id' => 1,
  //         'barang_id' => 1,
  //         'harga' => 650000,
  //         'jumlah' => 1
  //     ];
  //     PenjualanDetailModel::insert($data);

  //     $detail = PenjualanDetailModel::all();
  //     return view('penjualan_detail', ['data' => $detail]);

  // }

  // public function index()
  // {
  //   $detail = PenjualanDetailModel::all();
  //   return view('penjualan_detail', ['data' => $detail]);
  // }

  // public function tambah()
  // {
  //   return view('penjualan_detail_tambah');
  // }

  // public function tambah_simpan(Request $request)
  // {
  //   PenjualanDetailModel::create([
  //     'penjualan_id' => $request->penjualan_id,
  //     'barang_id' => $request->barang_id,
  //     'harga' => $request->harga,
  //     'jumlah' => $request->jumlah,
  //   ]);

  //   return redirect('/penjualan-detail');
  // }

  // public function ubah($id)
  // {
  //   $detail = PenjualanDetailModel::find($id);
  //   return view('penjualan_detail_ubah', ['data' => $detail]);
  // }

  // public function ubah_simpan($id, Request $request)
  // {
  //   $detail = PenjualanDetailModel::find($id);

  //   $detail->penjualan_id = $request->penjualan_id;
  //   $detail->barang_id = $request->barang_id;
  //   $detail->harga = $request->harga;
  //   $detail->jumlah = $request->jumlah;

  //   $detail->save();

  //   return redirect('/penjualan-detail');
  // }

  // public function hapus($id)
  // {
  //   $detail = PenjualanDetailModel::find($id);
  //   $detail->delete();

  //   return redirect('/penjualan-detail');
  // }
}