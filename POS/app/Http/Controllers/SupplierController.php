<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SupplierModel;

class SupplierController extends Controller
{
  // public function index()
  // {
  // ============================
  // | JOBSHEET 3 - PRAKTIKUM 4 |
  // ============================
  // DB::insert('insert into m_supplier(supplier_kode, supplier_nama, supplier_alamat, created_at) values(?, ?, ?, ?)', ['SUP04', 'PT Makmur Jaya', 'JL budi utomo', now()]);
  // return 'Insert data baru berhasil';

  // $row = DB::update('update m_supplier set supplier_nama = ? where supplier_kode = ?', ['PT Makmur Sejati', 'SUP02']);
  // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

  // $row = DB::delete('delete from m_supplier where supplier_kode = ?', ['SUP03']);
  // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

  // $data = DB::select('select * from m_supplier');
  // return view('supplier', ['data' => $data]);

  // ============================
  // | JOBSHEET 4 - PRAKTIKUM 1 |
  // ============================
  //       $data = [
  //         'supplier_kode' => 'SUP004',
  //         'supplier_nama' => 'PT Raja Selamanya',
  //         'supplier_alamat' => 'Jl. Flamboyan No. 1'
  //     ];
  //     SupplierModel::insert($data);

  //     $supplier = SupplierModel::all();
  //     return view('supplier', ['data' => $supplier]);
  // }

  public function index()
  {
    $supplier = SupplierModel::all();
    return view('supplier', ['data' => $supplier]);
  }

  public function tambah()
  {
    return view('supplier_tambah');
  }

  public function tambah_simpan(Request $request)
  {
    SupplierModel::create([
      'supplier_kode' => $request->supplier_kode,
      'supplier_nama' => $request->supplier_nama,
    ]);

    return redirect('/supplier');
  }

  public function ubah($id)
  {
    $supplier = SupplierModel::find($id);
    return view('supplier_ubah', ['data' => $supplier]);
  }

  public function ubah_simpan($id, Request $request)
  {
    $supplier = SupplierModel::find($id);

    $supplier->supplier_kode = $request->supplier_kode;
    $supplier->supplier_nama = $request->supplier_nama;

    $supplier->save();

    return redirect('/supplier');
  }

  public function hapus($id)
  {
    $supplier = SupplierModel::find($id);
    $supplier->delete();

    return redirect('/supplier');
  }
}