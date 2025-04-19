@extends('layouts.template')
@section('content')
  <div class="card card-outline card-primary">
    <div class="card-header">
    <h3 class="card-title">{{ $page->title }}</h3>
    <div class="card-tools">
      <button onclick="modalAction('{{ url('/barang/import') }}')" class="btn btn-info"><i class="fa fa-file-excel"></i> Import Barang</button>
      <a href="{{ url(path: '/barang/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i>
      Export Barang</a>
      <button onclick="modalAction('{{ url('/barang/create_ajax') }}')" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Data</button>
    </div>
    </div>
    <div class="card-body">
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
    @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

    <div class="row">
      <div class="col-md-12">
      <div class="form-group row">
        <label class="col-1 control-label col-form-label">Filter:</label>
        <div class="col-3">
        <select class="form-control" id="kategori_id" name="kategori_id">
          <option value="">- Semua -</option>
          @foreach($kategori as $item)
        <option value="{{ $item->kategori_id }}">{{ $item->kategori_nama }}</option>
      @endforeach
        </select>
        <small class="form-text text-muted">Kategori Barang</small>
        </div>
      </div>
      </div>
    </div>

    <table class="table table-bordered table-striped table-hover table-sm" id="table_barang">
      <thead>
      <tr>
        <th>ID</th>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Kategori</th>
        <th>Harga Beli</th>
        <th>Harga Jual</th>
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

    var dataBarang;

    $(document).ready(function () {
    dataBarang = $('#table_barang').DataTable({
      serverSide: true,
      ajax: {
      "url": "{{ url('barang/list') }}",
      "dataType": "json",
      "type": "POST",
      "data": function (d) {
        d.kategori_id = $('#kategori_id').val();
      }
      },
      columns: [
      {
        data: "barang_id",
        className: "text-center",
        orderable: true,
        searchable: true
      },
      {
        data: "barang_kode",
        className: "",
        orderable: true,
        searchable: true
      },
      {
        data: "barang_nama",
        className: "",
        orderable: true,
        searchable: true
      },
      {
        data: "kategori_nama",
        className: "",
        orderable: true,
        searchable: true
      },
      {
        data: "harga_beli",
        className: "",
        orderable: true,
        searchable: true
      },
      {
        data: "harga_jual",
        className: "",
        orderable: true,
        searchable: true
      },
      {
        data: "aksi",
        className: "text-center",
        orderable: false,
        searchable: false
      }
      ]
    });
    // Event tombol lihat detail
    $(document).on('click', '.btn-show-barang', function (e) {
      e.preventDefault();
      var id = $(this).data('id');

      $.ajax({
      url: '/barang/show_ajax/' + id,
      type: 'GET',
      success: function (response) {
        $('#myModal').html(response).modal('show');
      },
      error: function () {
        Swal.fire('Error', 'Gagal memuat detail barang', 'error');
      }
      });
    });
    $('#kategori_id').on('change', function () {
      dataBarang.ajax.reload();
    });
    });
  </script>
@endpush