<?php

namespace App\Http\Controllers;

use App\Models\StokModel;
use App\Models\BarangModel;
use App\Models\SupplierModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

class StokController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Stok',
            'list' => ['Home', 'Stok']
        ];

        $page = (object) [
            'title' => 'Daftar data stok barang'
        ];

        $activeMenu = 'stok';

        $barang = BarangModel::all(); // untuk filter barang

        return view('stok.index', compact('breadcrumb', 'page', 'activeMenu', 'barang'));
    }

    public function list(Request $request)
    {
        $stok = StokModel::with(['barang', 'user', 'supplier']);

        if ($request->barang_id) {
            $stok->where('barang_id', $request->barang_id);
        }

        return DataTables::of($stok)
            ->addIndexColumn()
            ->addColumn('aksi', function ($s) {
                $btn = '<a href="' . url('/stok/' . $s->stok_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/stok/' . $s->stok_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/stok/' . $s->stok_id) . '">'
                    . csrf_field()
                    . method_field('DELETE')
                    . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus data ini?\');">Hapus</button>'
                    . '</form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Stok',
            'list' => ['Home', 'Stok', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah data stok baru'
        ];

        $barang = BarangModel::all();
        $user = UserModel::all();
        $supplier = SupplierModel::all(); // Tambahkan supplier
        $activeMenu = 'stok';

        return view('stok.create', compact('breadcrumb', 'page', 'barang', 'user', 'supplier', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|integer',
            'user_id' => 'required|integer',
            'supplier_id' => 'required|integer',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer|min:1',
        ]);

        StokModel::create($request->all());

        return redirect('/stok')->with('success', 'Data stok berhasil disimpan');
    }

    public function show($id)
    {
        $stok = StokModel::with(['barang', 'user', 'supplier'])->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Stok',
            'list' => ['Home', 'Stok', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail data stok'
        ];

        $activeMenu = 'stok';

        return view('stok.show', compact('breadcrumb', 'page', 'stok', 'activeMenu'));
    }

    public function edit($id)
    {
        $stok = StokModel::find($id);
        $barang = BarangModel::all();
        $user = UserModel::all();
        $supplier = SupplierModel::all(); // Tambahkan supplier

        $breadcrumb = (object) [
            'title' => 'Edit Stok',
            'list' => ['Home', 'Stok', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit data stok'
        ];

        $activeMenu = 'stok';

        return view('stok.edit', compact('breadcrumb', 'page', 'stok', 'barang', 'user', 'supplier', 'activeMenu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_id' => 'required|integer',
            'user_id' => 'required|integer',
            'supplier_id' => 'required|integer',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer|min:1',
        ]);

        StokModel::find($id)->update($request->all());

        return redirect('/stok')->with('success', 'Data stok berhasil diubah');
    }

    public function destroy($id)
    {
        $check = StokModel::find($id);

        if (!$check) {
            return redirect('/stok')->with('error', 'Data stok tidak ditemukan');
        }

        try {
            StokModel::destroy($id);
            return redirect('/stok')->with('success', 'Data stok berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/stok')->with('error', 'Gagal menghapus data stok karena data masih terhubung dengan tabel lain');
        }
    }

    // Jobsheet 8
    // Tugas 1

    public function import()
    {
        return view('stok.import');
    }
    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = ['file_stok' => ['required', 'mimes:xlsx', 'max:5120']];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_stok');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);
            $insert = [];

            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $insert[] = [
                            'supplier_id' => $value['A'],
                            'barang_id' => $value['B'],
                            'user_id' => $value['C'],
                            'stok_tanggal' => $value['D'],
                            'stok_jumlah' => $value['E'],
                            'created_at' => now()
                        ];
                    }
                }
                if (count($insert) > 0) {
                    StokModel::insertOrIgnore($insert);
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
        $stok = StokModel::select('stok_id', 'supplier_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah')
        ->orderBy('barang_id')
        ->with('user')->with('supplier')->with('barang')
        ->get();

        // load library excel
        // Kemudian kita load library Spreadsheet dan kita tentukan header data pada baris pertama di excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil yang active

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'ID Stok');
        $sheet->setCellValue('C1', 'Nama Barang');
        $sheet->setCellValue('D1', 'Supplier');
        $sheet->setCellValue('E1', 'Tanggal Stok');
        $sheet->setCellValue('F1', 'Pengguna');
        $sheet->setCellValue('G1', 'Jumlah Stok');

        $sheet->getStyle('A1:G1')->getFont()->setBold(true); // bold header

        // Selanjutnya, kita looping data yang telah kita dapatkan dari database, kemudian kita masukkan ke dalam cell excel
        $no = 1;
        $baris = 2;
        foreach ($stok as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->stok_id);
            $sheet->setCellValue('C' . $baris, $value->barang->barang_nama);
            $sheet->setCellValue('D' . $baris, $value->supplier->supplier_nama);
            $sheet->setCellValue('E' . $baris, $value->stok_tanggal);
            $sheet->setCellValue('F' . $baris, $value->user->nama);
            $sheet->setCellValue('G' . $baris, $value->stok_jumlah);
            $baris++;
            $no++;
        }

        // Kita set lebar tiap kolom di excel untuk menyesuaikan dengan panjang karakter pada masing-masing kolom
        foreach (range('A', 'G') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size kolom
        }

        // Bagian akhir proses export excel adalah kita set nama sheet, dan proses untuk dapat di download oleh pengguna
        $sheet->setTitle('Data stok'); // set title sheet

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Stok ' . date('Y-m-d H:i:s') . '.xlsx';

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
        $stok = StokModel::select('stok_id', 'stok_kode', 'stok_nama')->orderBy('stok_id')->get();


        // use Barryvdh\\DomPDF\\Facade\\Pdf;
        $pdf = Pdf::loadView('stok.export_pdf', ['stok' => $stok]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption('isRemoteEnabled', true); // set true jika ada gambar dari url
        $pdf->render();

        return $pdf->stream('Data Stok ' . date('Y-m-d H:i:s') . '.pdf');
    }
}