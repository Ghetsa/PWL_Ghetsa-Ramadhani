@empty($penjualan)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ url('/penjualan') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Informasi Umum Penjualan -->
                <table class="table table-sm mb-4">
                    <tbody style="font-size: 0.95rem;">
                        <tr>
                            <th class="text-muted" style="width: 30%;">ID Penjualan</th>
                            <td>{{ $penjualan->penjualan_id }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Kode Penjualan</th>
                            <td>{{ $penjualan->penjualan_kode }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Tanggal</th>
                            <td>{{ \Carbon\Carbon::parse($penjualan->penjualan_tanggal)->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Pengguna</th>
                            <td>{{ $penjualan->user->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Dibuat pada</th>
                            <td>{{ $penjualan->created_at ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Diperbarui pada</th>
                            <td>{{ $penjualan->updated_at ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Detail Barang Terjual -->
                <h6 class="text-muted">Detail Barang Terjual:</h6>
                <table class="table table-sm table-bordered table-striped">
                    <thead>
                        <tr class="bg-light">
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penjualan->detail as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->barang->barang_nama ?? '-' }}</td>
                            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data detail penjualan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($penjualan->detail->count() > 0)
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Total</th>
                            <th>Rp {{ number_format($penjualan->detail->sum(fn($d) => $d->harga * $d->jumlah), 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-outline-dark">Tutup</button>
            </div>
        </div>
    </div>
@endempty
