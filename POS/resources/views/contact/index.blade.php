@extends('layouts.template')
@section('title', 'Kontak Developer')

@section('content')
  <div class="container py-4">
    <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-sm rounded-lg border-0">
      <div class="card-header bg-white border-bottom">
        <h5 class="mb-0">Kontak Developer</h5>
      </div>
      <div class="card-body text-center">

        {{-- Foto Developer --}}
        <div class="mb-4">
        <img src="{{ asset('images/image.jpg') }}" class="rounded-circle"
          style="width: 150px; height: 150px; object-fit: cover;" alt="Foto Developer">
        </div>

        {{-- Informasi Developer --}}
        <div class="text-left w-75 mx-auto">
        <div class="mb-2 d-flex justify-content-between">
          <span class="font-weight-bold">Nama Lengkap</span>
          <span>Ghetsa Ramadhani Riska Arryanti</span>
        </div>
        <div class="mb-2 d-flex justify-content-between">
          <span class="font-weight-bold">Nomor Absen</span>
          <span>11</span>
        </div>
        <div class="mb-2 d-flex justify-content-between">
          <span class="font-weight-bold">NIM</span>
          <span>2341720004</span>
        </div>
        <div class="mb-2 d-flex justify-content-between">
          <span class="font-weight-bold">Kelas</span>
          <span>TI-2D</span>
        </div>
        <div class="mb-2 d-flex justify-content-between">
          <span class="font-weight-bold">Jurusan</span>
          <span>Teknologi Informasi</span>
        </div>
        <div class="mb-2 d-flex justify-content-between">
          <span class="font-weight-bold">Prodi</span>
          <span>D4 - Teknik Informatika</span>
        </div>
        <div class="mb-2 d-flex justify-content-between">
          <span class="font-weight-bold">LinkedIn</span>
          <a href="https://www.linkedin.com/in/ghetsa-ramadhani-riska-arryanti-6b261b2a2/"
          target="_blank">linkedin.com/in/ghetsa-ramadhani-riska-arryanti</a>
        </div>
        <div class="mb-3 d-flex justify-content-between">
          <span class="font-weight-bold">GitHub</span>
          <a href="https://github.com/Ghetsa" target="_blank">github.com/Ghetsa</a>
        </div>
        </div>

        {{-- Optional: Tombol Kirim Email --}}
        <a href="mailto:ghetsa.arryanti@gmail.com" class="btn btn-outline-primary mt-3 rounded-pill px-4">
        Hubungi via Email
        </a>
      </div>
      </div>
    </div>
    </div>
  </div>
@endsection