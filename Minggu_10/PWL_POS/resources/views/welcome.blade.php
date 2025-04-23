@extends('layouts.template')

@section('content')
    <div class="alert alert-info">
        Halo, <strong>{{ Auth::user()->nama }}</strong>! Selamat datang di sistem informasi penjualan.
    </div>

    <div class="row">
        <!-- Kategori Barang -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $totalKategori }}</h3>
                    <p>Kategori Barang</p>
                </div>
                <div class="icon">
                    <i class="fa fa-th-list"></i>
                </div>
            </div>
        </div>

        <!-- Data Barang -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalBarang }}</h3>
                    <p>Data Barang</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box"></i>
                </div>
            </div>
        </div>

        <!-- Stok Barang -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalStok }}</h3>
                    <p>Stok Barang</p>
                </div>
                <div class="icon">
                    <i class="fas fa-warehouse"></i>
                </div>
            </div>
        </div>

        <!-- Total Penjualan -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</h3>
                    <p>Total Penjualan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- Tabel Transaksi Penjualan Terbaru -->
    <div class="card mt-4">
        <div class="card-header bg-success text-white">
            <h5><b>Transaksi Penjualan Terbaru</b></h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-success">
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Pembeli</th>
                        <th>Tanggal</th>
                        <th>Total Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penjualanTerbaru as $index => $penjualan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $penjualan->penjualan_kode }}</td>
                            <td>{{ $penjualan->pembeli }}</td>
                            <td>{{ date('d-m-Y H:i', strtotime($penjualan->penjualan_tanggal)) }}</td>
                            <td>Rp {{ number_format($penjualan->total_bayar, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')

@endpush