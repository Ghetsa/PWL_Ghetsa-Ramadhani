<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;
use App\Models\BarangModel;
use App\Models\UserModel;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
  // =============================================
  // JOBSHEET 5 - TUGAS
  // =============================================

  public function index()
  {
    $breadcrumb = (object) [
      'title' => 'Data Penjualan',
      'list' => ['Home', 'Penjualan']
    ];

    $page = (object) [
      'title' => 'Daftar data penjualan'
    ];

    $activeMenu = 'penjualan';
    $barang = BarangModel::all();

    return view('penjualan.index', compact('breadcrumb', 'page', 'activeMenu', 'barang'));
  }

  public function list(Request $request)
  {
    $penjualan = PenjualanModel::with(['user']);
    return DataTables::of($penjualan)
      ->addIndexColumn()
      ->addColumn('aksi', function ($p) {
        $btn = '<a href="' . url('/penjualan/' . $p->penjualan_id) . '" class="btn btn-info btn-sm">Detail</a> ';
        $btn .= '<a href="' . url('/penjualan/' . $p->penjualan_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
        $btn .= '<form class="d-inline-block" method="POST" action="' . url('/penjualan/' . $p->penjualan_id) . '">' .
          csrf_field() .
          method_field('DELETE') .
          '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus data ini?\');">Hapus</button>' .
          '</form>';
        return $btn;
      })
      ->rawColumns(['aksi'])
      ->make(true);
  }

  public function create()
  {
    $breadcrumb = (object) [
      'title' => 'Tambah Penjualan',
      'list' => ['Home', 'Penjualan', 'Tambah']
    ];

    $page = (object) [
      'title' => 'Tambah data penjualan baru'
    ];

    $barang = BarangModel::all();
    $user = UserModel::all();
    $activeMenu = 'penjualan';

    return view('penjualan.create', compact('breadcrumb', 'page', 'barang', 'user', 'activeMenu'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'user_id' => 'required|integer',
      'penjualan_kode' => 'required|string',
      'penjualan_tanggal' => 'required|date',
      'barang_id' => 'required|array',
      'harga' => 'required|array',
      'jumlah' => 'required|array',
    ]);

    // Simpan data penjualan
    $penjualan = PenjualanModel::create($request->all());

    // Simpan detail penjualan
    foreach ($request->barang_id as $index => $barang_id) {
      PenjualanDetailModel::create([
        'penjualan_id' => $penjualan->penjualan_id, // ID penjualan yang baru disimpan
        'barang_id' => $barang_id,
        'harga' => $request->harga[$index],
        'jumlah' => $request->jumlah[$index],
      ]);
    }

    return redirect('/penjualan')->with('success', 'Data penjualan berhasil disimpan');
  }



  public function show($id)
  {
    $penjualan = PenjualanModel::with(['user', 'detail.barang'])->find($id);

    $breadcrumb = (object) [
      'title' => 'Detail Penjualan',
      'list' => ['Home', 'Penjualan', 'Detail']
    ];

    $page = (object) [
      'title' => 'Detail data penjualan'
    ];

    $activeMenu = 'penjualan';

    return view('penjualan.show', compact('breadcrumb', 'page', 'penjualan', 'activeMenu'));
  }

  public function edit($id)
  {
    $penjualan = PenjualanModel::find($id);
    $user = UserModel::all();
    $barang = BarangModel::all();

    $breadcrumb = (object) [
      'title' => 'Edit Penjualan',
      'list' => ['Home', 'Penjualan', 'Edit']
    ];

    $page = (object) [
      'title' => 'Edit data penjualan'
    ];

    $activeMenu = 'penjualan';

    return view('penjualan.edit', compact('breadcrumb', 'page', 'penjualan', 'user', 'activeMenu', 'barang'));
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'user_id' => 'required|integer',
      'penjualan_kode' => 'required|string',
      'penjualan_tanggal' => 'required|date',
      'detail' => 'required|array',  // Pastikan detail penjualan ada
    ]);

    // Update data penjualan utama
    $penjualan = PenjualanModel::find($id);
    $penjualan->update([
      'user_id' => $request->user_id,
      'penjualan_kode' => $request->penjualan_kode,
      'penjualan_tanggal' => $request->penjualan_tanggal,
    ]);

    // Update detail penjualan
    foreach ($request->detail as $index => $detail) {
      // Temukan detail yang sesuai dengan penjualan
      $penjualanDetail = PenjualanDetailModel::where('penjualan_id', $id)
        ->where('barang_id', $detail['barang_id'])
        ->first();

      // Jika detail sudah ada, update
      if ($penjualanDetail) {
        $penjualanDetail->update([
          'barang_id' => $detail['barang_id'],
          'jumlah' => $detail['jumlah'],
        ]);
      } else {
        // Jika detail belum ada, buat data baru
        PenjualanDetailModel::create([
          'penjualan_id' => $id,
          'barang_id' => $detail['barang_id'],
          'harga' => $detail['harga'],
          'jumlah' => $detail['jumlah'],
        ]);
      }
    }

    return redirect('/penjualan')->with('success', 'Data penjualan berhasil diubah');
  }


  public function destroy($id)
  {
    $check = PenjualanModel::find($id);

    if (!$check) {
      return redirect('/penjualan')->with('error', 'Data penjualan tidak ditemukan');
    }

    try {
      PenjualanModel::destroy($id);
      return redirect('/penjualan')->with('success', 'Data penjualan berhasil dihapus');
    } catch (\Illuminate\Database\QueryException $e) {
      return redirect('/penjualan')->with('error', 'Gagal menghapus data penjualan karena masih terhubung dengan data lain');
    }
  }
}
// public function index()
// {
// ============================
// | JOBSHEET 3 - PRAKTIKUM 4 |
// ============================
// DB::insert('insert into t_penjualan(user_id, pembeli, penjualan_kode, tanggal_penjualan, created_at) values(?, ?, ?, ?, ?)', [3, 'Ayu Widodo', 'TR011', now(), now()]);
// return 'Insert data baru berhasil';

// $row = DB::update('update t_penjualan set pembeli = ? where penjualan_kode = ?', ['Selina Bunga', 'PNJ11']);
// return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

// $row = DB::delete('delete from t_penjualan where penjualan_kode = ?', ['PNJ11']);
// return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

// $data = DB::select('select * from t_penjualan');
// return view('penjualan', ['data' => $data]);

// ============================
// | JOBSHEET 4 - PRAKTIKUM 1 |
// ============================
//       $data = [
//         'user_id' => 1,
//         'pembeli' => 'Andi',
//         'penjualan_kode' => 'TRX011',
//         'penjualan_tanggal' => now()
//     ];
//     PenjualanModel::insert($data);

//     $penjualan = PenjualanModel::all();
//     return view('penjualan', ['data' => $penjualan]);

// }

// public function index()
// {
//   $penjualan = PenjualanModel::all();
//   return view('penjualan', ['data' => $penjualan]);
// }

// public function tambah()
// {
//   return view('penjualan_tambah');
// }

// public function tambah_simpan(Request $request)
// {
//   PenjualanModel::create([
//     'user_id' => $request->user_id,
//     'pembeli' => $request->pembeli,
//     'penjualan_kode' => $request->penjualan_kode,
//     'penjualan_tanggal' => $request->penjualan_tanggal,
//   ]);

//   return redirect('/penjualan');
// }

// public function ubah($id)
// {
//   $penjualan = PenjualanModel::find($id);
//   return view('penjualan_ubah', ['data' => $penjualan]);
// }

// public function ubah_simpan($id, Request $request)
// {
//   $penjualan = PenjualanModel::find($id);

//   $penjualan->user_id = $request->user_id;
//   $penjualan->pembeli = $request->pembeli;
//   $penjualan->penjualan_kode = $request->penjualan_kode;
//   $penjualan->penjualan_tanggal = $request->penjualan_tanggal;

//   $penjualan->save();

//   return redirect('/penjualan');
// }

// public function hapus($id)
// {
//   $penjualan = PenjualanModel::find($id);
//   $penjualan->delete();

//   return redirect('/penjualan');
// }



// }