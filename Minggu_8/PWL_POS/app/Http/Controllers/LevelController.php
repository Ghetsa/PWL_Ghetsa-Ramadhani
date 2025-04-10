<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTable;
use Barryvdh\DomPDF\Facade\Pdf;


class LevelController extends Controller
{
    // public function index()
    // {
    //     DB::insert('insert into m_level(level_kode, level_nama, created_at) values(?, ?, ?)', ['CUS', 'Pelanggan', now()]);
    //     return 'Insert data baru berhasil';

    //     // $row = DB::update('update m_level set level_nama = ? where level_kode = ?', ['Customer', 'CUS']);
    //     // return 'Update data berhasil. Jumlah data yang diupdate: ' . $row . ' baris';

    //     // $row = DB::delete('delete from m_level where level_kode = ?', ['CUS']);
    //     // return 'Delete data berhasil. Jumlah data yang dihapus: ' . $row . ' baris';

    //     // $data = DB::select('select * from m_level');
    //     // return view('level', ['data' => $data]);
    // }

    // =============================================
    // JOBSHEET 5 - TUGAS
    // =============================================

    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Level',
            'list' => ['Home', 'Level']
        ];

        $page = (object) [
            'title' => 'Daftar level yang tersedia dalam sistem'
        ];

        $activeMenu = 'level';

        return view('level.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    // public function list()
    // {
    //     $levels = LevelModel::select('level_id', 'level_kode', 'level_nama');

    //     return DataTables::of($levels)
    //         ->addIndexColumn()
    //         ->addColumn('aksi', function ($level) {
    //             $btn = '<a href="' . url('/level/' . $level->level_id) . '" class="btn btn-info btn-sm">Detail</a> ';
    //             $btn .= '<a href="' . url('/level/' . $level->level_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
    //             $btn .= '<form class="d-inline-block" method="POST" action="' . url('/level/' . $level->level_id) . '">' .
    //                 csrf_field() . method_field('DELETE') .
    //                 '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\')">Hapus</button></form>';
    //             return $btn;
    //         })
    //         ->rawColumns(['aksi'])
    //         ->make(true);
    // }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Level',
            'list' => ['Home', 'Level', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah level baru'
        ];

        $activeMenu = 'level';

        return view('level.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'level_kode' => 'required|string|unique:m_level,level_kode',
            'level_nama' => 'required|string|max:100'
        ]);

        LevelModel::create($request->all());

        return redirect('/level')->with('success', 'Data level berhasil disimpan');
    }

    public function show($id)
    {
        $level = LevelModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Level',
            'list' => ['Home', 'Level', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail level'
        ];

        $activeMenu = 'level';

        return view('level.show', compact('breadcrumb', 'page', 'level', 'activeMenu'));
    }

    public function edit($id)
    {
        $level = LevelModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Level',
            'list' => ['Home', 'Level', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit level'
        ];

        $activeMenu = 'level';

        return view('level.edit', compact('breadcrumb', 'page', 'level', 'activeMenu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'level_kode' => 'required|string|unique:m_level,level_kode,' . $id . ',level_id',
            'level_nama' => 'required|string|max:100'
        ]);

        LevelModel::find($id)->update($request->all());

        return redirect('/level')->with('success', 'Data level berhasil diubah');
    }

    public function destroy($id)
    {
        $level = LevelModel::find($id);
        if (!$level) {
            return redirect('/level')->with('error', 'Data level tidak ditemukan');
        }

        try {
            LevelModel::destroy($id);
            return redirect('/level')->with('success', 'Data level berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/level')->with('error', 'Data level gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
    // =============================================
    // JOBSHEET 6 - TUGAS
    // =============================================
    // Praktikum 1 - Langkah 7
    public function create_ajax()
    {
        return view('level.create_ajax');
    }
    // Praktikum 1 - Langkah 9
    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|string|min:3|unique:m_level,level_kode',
                'level_nama' => 'required|string|max:100'
            ];


            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors() // pesan error validasi
                ]);
            }

            LevelModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data Level berhasil disimpan'
            ]);
        }

        redirect('/');
    }

    // Praktikum 2 - Langkah 2
    // Ambil data level dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $levels = LevelModel::select('level_id', 'level_kode', 'level_nama');

        return DataTables::of($levels)
            ->addIndexColumn()  // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($level) {  // menambahkan kolom aksi
    
                /* $btn = '<a href="'.url('/level/' . $level->level_id).'" class="btn btn-info btn-sm">Detail</a> ';
            $btn .= '<a href="'.url('/level/' . $level->level_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
            $btn .= '<form class="d-inline-block" method="POST" action="'. url('/level/'.$level->level_id).'">'
            . csrf_field() . method_field('DELETE') .
            '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';*/
                $btn = '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    // Praktikum 2 - Langkah 4
    // Menampilkan halaman form edit level ajax
    public function edit_ajax(string $id)
    {
        $level = LevelModel::find($id);

        return view('level.edit_ajax', ['level' => $level]);
    }

    // Praktikum 2 - Langkah 6
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|max:20|unique:m_level,level_kode,' . $id . ',level_id',
                'level_nama' => 'required|max:100'
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

            $check = LevelModel::find($id);
            if ($check) {
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
        $level = LevelModel::find($id);

        return view('level.confirm_ajax', ['level' => $level]);
    }


    // Praktikum 3 - Langkah 5
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $level = LevelModel::find($id);
            if ($level) {
                $level->delete();
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


    // Jobsheet 8
    // Tugas 1

    public function import()
    {
        return view('level.import');
    }
    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = ['file_level' => ['required', 'mimes:xlsx', 'max:5120']];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_level');
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
                            'level_kode' => $value['A'],
                            'level_nama' => $value['B'],
                            'created_at' => now()
                        ];
                    }
                }
                if (count($insert) > 0) {
                    LevelModel::insertOrIgnore($insert);
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
        $level = LevelModel::select('level_id', 'level_kode', 'level_nama')->orderBy('level_id')->get();

        // load library excel
        // Kemudian kita load library Spreadsheet dan kita tentukan header data pada baris pertama di excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil yang active

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'ID Level');
        $sheet->setCellValue('C1', 'Kode Level');
        $sheet->setCellValue('D1', 'Nama Level');

        $sheet->getStyle('A1:D1')->getFont()->setBold(true); // bold header

        // Selanjutnya, kita looping data yang telah kita dapatkan dari database, kemudian kita masukkan ke dalam cell excel
        $no = 1;
        $baris = 2;
        foreach ($level as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->level_id);
            $sheet->setCellValue('C' . $baris, $value->level_kode);
            $sheet->setCellValue('D' . $baris, $value->level_nama);
            $baris++;
            $no++;
        }

        // Kita set lebar tiap kolom di excel untuk menyesuaikan dengan panjang karakter pada masing-masing kolom
        foreach (range('A', 'D') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size kolom
        }

        // Bagian akhir proses export excel adalah kita set nama sheet, dan proses untuk dapat di download oleh pengguna
        $sheet->setTitle('Data Level'); // set title sheet

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Level ' . date('Y-m-d H:i:s') . '.xlsx';

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
        $level = LevelModel::select('level_id', 'level_kode', 'level_nama')->orderBy('level_id')->get();


        // use Barryvdh\\DomPDF\\Facade\\Pdf;
        $pdf = Pdf::loadView('level.export_pdf', ['level' => $level]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption('isRemoteEnabled', true); // set true jika ada gambar dari url
        $pdf->render();

        return $pdf->stream('Data Level ' . date('Y-m-d H:i:s') . '.pdf');
    }
}

