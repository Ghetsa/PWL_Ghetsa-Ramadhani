@extends('layouts.template')
@section('title', 'Edit Profil')

@section('content')
  <div class="container-fluid">
    <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title">Edit Profil</h3>
      </div>
      <div class="card-body">
        {{-- Foto Profil --}}
        <div class="text-center mb-4">
        @if(Auth::user()->foto)
      <img src="{{ asset('storage/foto_profil/' . Auth::user()->foto) }}" class="img-fluid rounded-circle"
        style="width: 150px; height: 150px; object-fit: cover;" alt="Foto Profil">
    @else
    <img src="{{ asset('adminlte/dist/img/user1.jpg') }}" class="img-fluid rounded-circle"
      style="width: 150px; height: 150px; object-fit: cover;" alt="Foto Default">
  @endif
        </div>
        {{-- Form Edit --}}
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label for="nama">Nama</label>
          <input type="text" name="nama" value="{{ old('nama', Auth::user()->nama) }}" class="form-control"
          required>
        </div>

        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" name="username" value="{{ old('username', Auth::user()->username) }}"
          class="form-control" required>
        </div>

        <div class="form-group">
          <label for="foto">Ganti Foto Profil</label>
          <div class="custom-file">
          <input type="file" class="custom-file-input" id="foto" name="foto" accept="image/*">
          <label class="custom-file-label" for="foto">Pilih file</label>
          </div>
        </div>


        <div class="text-right mt-4">
          <a href="{{ url('/profile') }}" class="btn btn-outline-secondary px-4">Kembali</a>
          <button type="submit" class="btn btn-primary px-4">Simpan</button>

        </div>
        </form>
      </div>

      </div>
    </div>
    </div>

    {{-- Validasi error --}}
    @if ($errors->any())
    <div class="alert alert-danger mt-3">
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
    </ul>
    </div>
  @endif
  </div>
@endsection

@push('js')
  <script src="{{ asset('adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(document).ready(function () {
    bsCustomFileInput.init();

    @if(session('success'))
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: '{{ session('success') }}',
      timer: 3000,
      showConfirmButton: false
    });
  @endif

    @if(session('error'))
    Swal.fire({
      icon: 'error',
      title: 'Gagal!',
      text: '{{ session('error') }}',
      timer: 3000,
      showConfirmButton: false
    });
  @endif
    });
  </script>
@endpush