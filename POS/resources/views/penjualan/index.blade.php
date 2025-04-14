@extends('layouts.template')

@section('content')
  <div class="card card-outline card-primary">
    <div class="card-header">
      <h3 class="card-title">Manajemen Penjualan</h3>
      <div class="card-tools d-flex gap-2">
        {{-- Tombol Tambah Penjualan --}}
        <a class="btn btn-sm btn-primary mt-1" href="{{ url('penjualan/create') }}">
          Tambah Penjualan
        </a>
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
@endsection

@push('css')
@endpush

@push('js')
<script>
  $(document).ready(function () {
    var dataPenjualan = $('#table_penjualan').DataTable({
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
