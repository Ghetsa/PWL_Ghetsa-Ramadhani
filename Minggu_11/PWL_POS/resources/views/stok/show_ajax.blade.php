@empty($stok)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ url('/stok') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data Stok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm">
                    <tbody style="font-size: 0.95rem;">
                        <tr>
                            <th class="text-muted" style="width: 30%;">ID</th>
                            <td>{{ $stok->stok_id }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Barang</th>
                            <td>{{ $stok->barang->barang_nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Pengguna</th>
                            <td>{{ $stok->user->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Supplier</th>
                            <td>{{ $stok->supplier->supplier_nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Tanggal Stok</th>
                            <td>{{ \Carbon\Carbon::parse($stok->stok_tanggal)->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Jumlah Stok</th>
                            <td>{{ $stok->stok_jumlah }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Dibuat pada</th>
                            <td>{{ $stok->created_at ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Diperbarui pada</th>
                            <td>{{ $stok->updated_at ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-outline-dark">Tutup</button>
            </div>
        </div>
    </div>
@endempty
