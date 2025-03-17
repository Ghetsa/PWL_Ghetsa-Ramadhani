@extends('layouts.app')
{{-- Customize layout sections --}}
@section('subtitle', 'Kategori')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Kategori')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Edit Kategori</div>
            <div class="card-body">
                <form action="{{ route('kategori.update', $kategori->kategori_id) }}" method="POST">
                    @csrf
                    @method('PUT') <!-- Tambahkan ini untuk mengubah method POST menjadi PUT -->

                    <div class="form-group">
                        <label>Kode Kategori</label>
                        <input type="text" name="kategori_kode" class="form-control" value="{{ $kategori->kategori_kode }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" name="kategori_nama" class="form-control" value="{{ $kategori->kategori_nama }}"
                            required>
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>
                </form>

            </div>
        </div>
    </div>
@endsection