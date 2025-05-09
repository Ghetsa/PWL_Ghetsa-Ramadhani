<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;
use App\Models\BarangModel;
use App\Models\UserModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;


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
      ->addColumn('aksi', function ($penjualan) {
        $btn = '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
        $btn .= '<a href="' . url('/penjualan/' . $penjualan->penjualan_id . '/cetak_struk') . '" target="_blank" class="btn btn-warning btn-sm">Cetak Struk</a> ';
        $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
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
    // Hitung total bayar
    $total_bayar = 0;
    foreach ($request->barang_id as $i => $barang_id) {
      $total_bayar += $request->harga[$i] * $request->jumlah[$i];
    }
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
      'barang_id' => 'required|array',
      'harga' => 'required|array',
      'jumlah' => 'required|array',
    ]);

    // Hitung total bayar
    $total_bayar = 0;
    foreach ($request->barang_id as $i => $barang_id) {
      $total_bayar += $request->harga[$i] * $request->jumlah[$i];
    }

    // Update data utama
    $penjualan = PenjualanModel::find($id);
    $penjualan->update([
      'user_id' => $request->user_id,
      'penjualan_kode' => $request->penjualan_kode,
      'penjualan_tanggal' => $request->penjualan_tanggal,
      'total_bayar' => $total_bayar,
    ]);

    // Hapus semua detail lama
    PenjualanDetailModel::where('penjualan_id', $id)->delete();

    // Simpan detail baru
    foreach ($request->barang_id as $i => $barang_id) {
      PenjualanDetailModel::create([
        'penjualan_id' => $id,
        'barang_id' => $barang_id,
        'harga' => $request->harga[$i],
        'jumlah' => $request->jumlah[$i]
      ]);
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

  public function create_ajax()
  {
    $user = UserModel::all();
    $barang = BarangModel::all();

    return view('penjualan.create_ajax', compact('user', 'barang'));
  }

  // Simpan data penjualan via AJAX
  public function store_ajax(Request $request)
  {
    if ($request->ajax() || $request->wantsJson()) {
      $rules = [
        'user_id' => 'required|integer',
        'penjualan_kode' => 'required|string',
        'penjualan_tanggal' => 'required|date',
        'barang_id' => 'required|array',
        'harga' => 'required|array',
        'jumlah' => 'required|array',
      ];

      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
        return response()->json([
          'status' => false,
          'message' => 'Validasi gagal.',
          'msgField' => $validator->errors()
        ]);
      }

      DB::beginTransaction();
      $total_bayar = 0;
      foreach ($request->barang_id as $i => $barang_id) {
        $total_bayar += $request->harga[$i] * $request->jumlah[$i];
      }
      try {
        // Simpan data utama penjualan
        $penjualan = PenjualanModel::create([
          'user_id' => $request->user_id,
          'pembeli' => $request->pembeli,
          'penjualan_kode' => $request->penjualan_kode,
          'penjualan_tanggal' => $request->penjualan_tanggal,
          'total_bayar' => $total_bayar
        ]);

        // Loop barang yang dibeli
        foreach ($request->barang_id as $i => $barang_id) {
          $jumlah = $request->jumlah[$i];
          $harga = $request->harga[$i];

          // Ambil stok dan nama barang
          $barang = DB::table('m_barang')->where('barang_id', $barang_id)->first();
          $stokSekarang = DB::table('t_stok')->where('barang_id', $barang_id)->value('stok_jumlah');

          if ($stokSekarang < $jumlah) {
            throw new \Exception("Stok barang '{$barang->barang_nama}' tidak mencukupi. Tersisa: $stokSekarang, Diminta: $jumlah");
          }

          // Simpan detail penjualan
          PenjualanDetailModel::create([
            'penjualan_id' => $penjualan->penjualan_id,
            'barang_id' => $barang_id,
            'harga' => $harga,
            'jumlah' => $jumlah
          ]);

          // Kurangi stok
          DB::table('t_stok')
            ->where('barang_id', $barang_id)
            ->decrement('stok_jumlah', $jumlah);
        }

        DB::commit(); // <-- PENTING!

        return response()->json([
          'status' => true,
          'message' => 'Data penjualan berhasil disimpan'
        ]);
      } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
          'status' => false,
          'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
        ]);
      }
    }

    return redirect('/');
  }

  // Tampilkan form edit penjualan via AJAX
  public function edit_ajax(string $id)
  {
    $penjualan = PenjualanModel::with('detail')->find($id);
    $user = UserModel::all();
    $barang = BarangModel::all();

    return view('penjualan.edit_ajax', compact('penjualan', 'user', 'barang'));
  }

  // Update data penjualan via AJAX
  public function update_ajax(Request $request, string $id)
  {
    if ($request->ajax() || $request->wantsJson()) {
      $rules = [
        'user_id' => 'required|integer',
        'pembeli' => 'required|string|max:255',
        'penjualan_kode' => 'required|string',
        'penjualan_tanggal' => 'required|date',
        'barang_id' => 'required|array',
        'harga' => 'required|array',
        'jumlah' => 'required|array',
      ];

      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
        return response()->json([
          'status' => false,
          'message' => 'Validasi gagal.',
          'msgField' => $validator->errors()
        ]);
      }

      DB::beginTransaction();
      try {
        $penjualan = PenjualanModel::find($id);

        if (!$penjualan) {
          return response()->json([
            'status' => false,
            'message' => 'Data penjualan tidak ditemukan.'
          ]);
        }

        // Hitung ulang total bayar
        $total_bayar = 0;
        foreach ($request->barang_id as $i => $barang_id) {
          $total_bayar += $request->harga[$i] * $request->jumlah[$i];
        }

        // Update data utama
        $penjualan->update([
          'user_id' => $request->user_id,
          'pembeli' => $request->pembeli,
          'penjualan_kode' => $request->penjualan_kode,
          'penjualan_tanggal' => $request->penjualan_tanggal,
          'total_bayar' => $total_bayar
        ]);

        // Hapus detail lama
        PenjualanDetailModel::where('penjualan_id', $penjualan->penjualan_id)->delete();

        // Simpan detail baru
        foreach ($request->barang_id as $i => $barang_id) {
          PenjualanDetailModel::create([
            'penjualan_id' => $penjualan->penjualan_id,
            'barang_id' => $barang_id,
            'harga' => $request->harga[$i],
            'jumlah' => $request->jumlah[$i]
          ]);
        }

        DB::commit();
        return response()->json([
          'status' => true,
          'message' => 'Data penjualan berhasil diperbarui.'
        ]);
      } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
          'status' => false,
          'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ]);
      }
    }

    return redirect('/');
  }


  // Konfirmasi hapus data penjualan (opsional: untuk modal AJAX)
  public function confirm_ajax(string $id)
  {
    $penjualan = PenjualanModel::find($id);
    return view('penjualan.confirm_ajax', compact('penjualan'));
  }

  // Hapus data penjualan via AJAX
  public function delete_ajax(Request $request, string $id)
  {
    if ($request->ajax() || $request->wantsJson()) {
      $penjualan = PenjualanModel::find($id);
      if ($penjualan) {
        $penjualan->delete();

        return response()->json([
          'status' => true,
          'message' => 'Data penjualan berhasil dihapus'
        ]);
      } else {
        return response()->json([
          'status' => false,
          'message' => 'Data penjualan tidak ditemukan'
        ]);
      }
    }

    return redirect('/');
  }

  public function show_ajax($id)
  {
    $penjualan = PenjualanModel::find($id);

    return view('penjualan.show_ajax', compact('penjualan'));
  }


  // =============================================
  // JOBSHEET 8
  // =============================================
  // =============================================
// IMPORT
// =============================================

  public function import()
  {
    return view('penjualan.import');
  }

  public function import_ajax(Request $request)
  {
    if ($request->ajax() || $request->wantsJson()) {
      $rules = ['file_penjualan' => ['required', 'mimes:xlsx', 'max:5120']];
      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
        return response()->json([
          'status' => false,
          'message' => 'Validasi Gagal',
          'msgField' => $validator->errors()
        ]);
      }

      $file = $request->file('file_penjualan');
      $reader = IOFactory::createReader('Xlsx');
      $reader->setReadDataOnly(true);
      $spreadsheet = $reader->load($file->getRealPath());
      $sheet = $spreadsheet->getActiveSheet();
      $data = $sheet->toArray(null, false, true, true);

      if (count($data) <= 1) {
        return response()->json([
          'status' => false,
          'message' => 'Tidak ada data yang diimport'
        ]);
      }

      DB::beginTransaction();
      try {
        $lastKode = '';
        $penjualan = null;
        $total_bayar = 0;

        foreach ($data as $baris => $row) {
          if ($baris <= 1)
            continue; // Skip header

          $kode = $row['A']; // penjualan_kode
          $tanggal = $row['B']; // penjualan_tanggal
          $pembeli = $row['C']; // pembeli
          $user_id = $row['D']; // user_id
          $barang_id = $row['E'];
          $harga = $row['F'];
          $jumlah = $row['G'];

          if ($lastKode != $kode) {
            // Simpan penjualan sebelumnya jika ada
            if ($penjualan) {
              $penjualan->total_bayar = $total_bayar;
              $penjualan->save();
              $total_bayar = 0;
            }

            // Buat baru
            $penjualan = PenjualanModel::create([
              'penjualan_kode' => $kode,
              'penjualan_tanggal' => $tanggal,
              'pembeli' => $pembeli,
              'user_id' => $user_id,
              'total_bayar' => 0
            ]);
            $lastKode = $kode;
          }

          $barang = DB::table('m_barang')->where('barang_id', $barang_id)->first();
          $stok = DB::table('t_stok')->where('barang_id', $barang_id)->value('stok_jumlah');

          if ($stok < $jumlah) {
            throw new \Exception("Stok barang '{$barang->barang_nama}' tidak mencukupi pada baris {$baris}.");
          }

          PenjualanDetailModel::create([
            'penjualan_id' => $penjualan->penjualan_id,
            'barang_id' => $barang_id,
            'harga' => $harga,
            'jumlah' => $jumlah
          ]);

          // Kurangi stok
          DB::table('t_stok')
            ->where('barang_id', $barang_id)
            ->decrement('stok_jumlah', $jumlah);

          $total_bayar += $harga * $jumlah;
        }

        // Simpan total bayar terakhir
        if ($penjualan) {
          $penjualan->total_bayar = $total_bayar;
          $penjualan->save();
        }

        DB::commit();

        return response()->json([
          'status' => true,
          'message' => 'Data penjualan berhasil diimport'
        ]);
      } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
          'status' => false,
          'message' => 'Terjadi kesalahan saat import: ' . $e->getMessage()
        ]);
      }
    }

    return redirect('/');
  }


  public function export_excel()
  {
    $penjualan = PenjualanModel::with(['user', 'detail.barang'])
      ->orderBy('penjualan_tanggal')
      ->get();

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Kode Penjualan');
    $sheet->setCellValue('C1', 'Tanggal');
    $sheet->setCellValue('D1', 'Kasir');
    $sheet->setCellValue('E1', 'Barang');
    $sheet->setCellValue('F1', 'Harga');
    $sheet->setCellValue('G1', 'Jumlah');
    $sheet->setCellValue('H1', 'Subtotal');

    $sheet->getStyle('A1:H1')->getFont()->setBold(true);

    $baris = 2;
    $no = 1;

    foreach ($penjualan as $p) {
      foreach ($p->detail as $d) {
        $sheet->setCellValue('A' . $baris, $no++);
        $sheet->setCellValue('B' . $baris, $p->penjualan_kode);
        $sheet->setCellValue('C' . $baris, $p->penjualan_tanggal);
        $sheet->setCellValue('D' . $baris, $p->user->nama ?? '-');
        $sheet->setCellValue('E' . $baris, $d->barang->barang_nama ?? '-');
        $sheet->setCellValue('F' . $baris, $d->harga);
        $sheet->setCellValue('G' . $baris, $d->jumlah);
        $sheet->setCellValue('H' . $baris, $d->harga * $d->jumlah);
        $baris++;
      }
    }

    foreach (range('A', 'H') as $columnID) {
      $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    $sheet->setTitle('Data Penjualan');

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $filename = 'Data Penjualan ' . date('Y-m-d H-i-s') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment;filename=\"$filename\"");
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
  }

  public function export_pdf()
  {
    $penjualan = PenjualanModel::with(['user', 'detail.barang'])
      ->orderBy('penjualan_id', 'asc')
      ->get();

    $pdf = Pdf::loadView('penjualan.export_pdf', ['penjualan' => $penjualan]);
    $pdf->setPaper('a4', 'landscape');
    $pdf->setOption('isRemoteEnabled', true);
    $pdf->render();

    return $pdf->stream('Data Penjualan ' . date('Y-m-d H:i:s') . '.pdf');
  }

  public function cetak_struk($id)
  {
      $penjualan = PenjualanModel::with(['user', 'detail.barang'])->find($id);
  
      if (!$penjualan) {
          return redirect('/penjualan')->with('error', 'Data penjualan tidak ditemukan.');
      }
  
      $pdf = Pdf::loadView('penjualan.cetak_struk', compact('penjualan'));
      $pdf->setPaper([0, 0, 250, 600], 'portrait'); // ukuran struk (mm ke point)
      $pdf->setOption('isRemoteEnabled', true);
      $pdf->render();

      return $pdf->stream('Struk-' . $penjualan->penjualan_kode . '.pdf');
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