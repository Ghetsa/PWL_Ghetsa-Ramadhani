@extends('layouts.template')
@section('title', 'Profil Saya')
@section('content')
<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-md-7">
      <div class="card shadow-sm rounded-lg border-0">
        <div class="card-header bg-white border-bottom">
          <h5 class="mb-0">Profil Saya</h5>
        </div>
        <div class="card-body text-center">

          {{-- Foto Profil --}}
          <div class="mb-4">
            <img src="{{ Auth::user()->foto 
                ? asset('storage/foto_profil/' . Auth::user()->foto) 
                : asset('adminlte/dist/img/user1.jpg') }}"
                class="rounded-circle "
                style="width: 130px; height: 130px; object-fit: cover;"
                alt="Foto Profil">
          </div>

          {{-- Informasi Pengguna --}}
          <div class="text-left w-50 mx-auto">
            <div class="mb-2 d-flex justify-content-between">
              <span class="font-weight-bold">Nama</span>
              <span>{{ Auth::user()->nama }}</span>
            </div>
            <div class="mb-2 d-flex justify-content-between">
              <span class="font-weight-bold">Username</span>
              <span>{{ Auth::user()->username }}</span>
            </div>
            <div class="mb-3 d-flex justify-content-between">
              <span class="font-weight-bold">Level</span>
              <span>{{ Auth::user()->level->level_nama }}</span>
            </div>
          </div>

          {{-- Tombol Edit --}}
          <a href="{{ route('profile.edit') }}" class="btn btn-primary rounded-pill px-4">
            Edit Profil
          </a>
        </div>
      </div>

      {{-- Notifikasi Error --}}
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
  </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  @if(session('success'))
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: '{{ session('success') }}',
      showConfirmButton: false,
      timer: 2000
    });
  @endif
</script>
@endpush
