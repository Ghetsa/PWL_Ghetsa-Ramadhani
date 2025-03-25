@extends('layouts.template')

@section('content')
  <div class="card card-outline card-primary">
    <div class="card-header">
      <h3 class="card-title">Manajemen Stok</h3>
      <div class="card-tools d-flex gap-2">
        {{-- Tombol Tambah Stok --}}
        <a class="btn btn-sm btn-primary mt-1" href="{{ url('stok/create') }}">
          Tambah Stok
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

      {{-- Filter Barang --}}
      <div class="row mb-3">
        <div class="col-md-6">
          <div class="form-group row">
            <label class="col-4 col-form-label">Filter Barang:</label>
            <div class="col-8">
              <select class="form-control" id="barang_id" name="barang_id">
                <option value="">- Semua -</option>
                @foreach($barang as $item)
                  <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
                @endforeach
              </select>
              <small class="form-text text-muted">Pilih barang untuk melihat stok terkait.</small>
            </div>
          </div>
        </div>
      </div>

      {{-- Tabel Data Stok --}}
      <table class="table table-bordered table-striped table-hover table-sm" id="table_stok">
        <thead>
          <tr>
            <th>ID</th>
            <th>Barang</th>
            <th>Jumlah Stok</th>
            <th>Supplier</th>
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
    // Inisialisasi DataTable
    var dataStok = $('#table_stok').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: "{{ url('stok/list') }}",
        type: "POST",
        data: function (d) {
          d.barang_id = $('#barang_id').val();
        }
      },
      columns: [
        { data: "stok_id", className: "text-center", orderable: true, searchable: true },
        { data: "barang.barang_nama", orderable: true, searchable: true },
        { data: "stok_jumlah", orderable: true, searchable: true },
        { data: "supplier.supplier_nama", orderable: true, searchable: true }, // Sesuaikan dengan database
        { data: "stok_tanggal", orderable: true, searchable: true },
        { data: "user.nama", orderable: true, searchable: true },
        { data: "aksi", className: "text-center", orderable: false, searchable: false }
      ]
    });

    // Event listener untuk filter barang
    $('#barang_id').on('change', function () {
      dataStok.ajax.reload();
    });
  });
</script>
@endpush
