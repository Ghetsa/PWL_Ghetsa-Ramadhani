@extends('layouts.template')

@section('content')
  <div class="card card-outline card-primary">
    <div class="card-header">
    <h3 class="card-title">Manajemen Penjualan</h3>
    <div class="card-tools">
      <button onclick="modalAction('{{ url('/penjualan/import') }}')" class="btn btn-info"><i
        class="fa fa-file-excel"></i> Import Penjualan</button>
      <a href="{{ url(path: '/penjualan/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i>
      Export Penjualan</a>
      <button onclick="modalAction('{{ url('/penjualan/create_ajax') }}')" class="btn btn-success"><i
        class="fa fa-plus"></i> Tambah Data</button>
    </div>
    </div>

    <div class="card-body">
    {{-- Notifikasi sukses atau error --}}
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
    @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

    {{-- (Opsional) Filter dapat ditambahkan di sini --}}

    {{-- Tabel Data Penjualan --}}
    <table class="table table-bordered table-striped table-hover table-sm" id="table_penjualan">
      <thead>
      <tr>
        <th>ID</th>
        <th>Kode</th>
        <th>Tanggal</th>
        <th>Pengguna</th>
        <th>Aksi</th>
      </tr>
      </thead>
    </table>
    </div>
  </div>
  <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
    data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
@endpush

@push('js')
  <script>
    function modalAction(url = '') {
    $('#myModal').load(url, function () {
      $('#myModal').modal('show');
    });
    }

    var dataPenjualan;
    $(document).ready(function () {
    dataPenjualan = $('#table_penjualan').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
      url: "{{ url('penjualan/list') }}",
      type: "POST"
      },
      columns: [
      { data: "penjualan_id", className: "text-center", orderable: true, searchable: true },
      { data: "penjualan_kode", orderable: true, searchable: true },
      { data: "penjualan_tanggal", orderable: true, searchable: true },
      { data: "user.nama", orderable: true, searchable: true },
      { data: "aksi", className: "text-center", orderable: false, searchable: false }
      ]
    });
    });
  </script>
@endpush