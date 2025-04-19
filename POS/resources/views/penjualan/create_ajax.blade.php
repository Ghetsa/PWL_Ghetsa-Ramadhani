<form action="{{ url('penjualan/ajax') }}" method="POST" id="form-penjualan">
    @csrf
    <div id="modal-penjualan" class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Pengguna</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->nama }}" disabled>
                    <input type="hidden" name="user_id" value="{{ auth()->user()->user_id }}">
                    <small id="error-user_id" class="error-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Pembeli</label>
                    <input type="text" name="pembeli" class="form-control" required>
                    <small id="error-pembeli" class="error-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Kode Penjualan</label>
                    <input type="text" name="penjualan_kode" class="form-control" required>
                    <small id="error-penjualan_kode" class="error-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Tanggal Penjualan</label>
                    <input type="datetime-local" name="penjualan_tanggal" class="form-control" required>
                    <small id="error-penjualan_tanggal" class="error-text text-danger"></small>
                </div>

                <h5 class="mt-4">Detail Penjualan</h5>
                <div id="barangDetails">
                    <div class="barang-detail row mb-2 align-items-end">
                        <div class="form-group col-md-4">
                            <label>Barang</label>
                            <select name="barang_id[]" class="form-control barang-select" required>
                                <option value="">- Pilih Barang -</option>
                                @foreach ($barang as $b)
                                    <option value="{{ $b->barang_id }}" data-harga="{{ $b->harga_jual }}">
                                        {{ $b->barang_nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Harga</label>
                            <input type="number" class="form-control harga" disabled required>
                            <input type="hidden" name="harga[]" class="harga-hidden">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Jumlah</label>
                            <input type="number" name="jumlah[]" class="form-control" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="d-block">&nbsp;</label>
                            <button type="button" class="btn btn-danger remove-barang"
                                style="height: 38px;">Hapus</button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary btn-sm mb-3" id="addBarang">Tambah Barang</button>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('#addBarang').on('click', function () {
            var barangDetail = $('.barang-detail').first().clone();
            barangDetail.find('input').val('');
            barangDetail.find('select').val('');
            $('#barangDetails').append(barangDetail);
        });

        // Otomatis isi harga saat barang dipilih
        $(document).on('change', '.barang-select', function () {
            let harga = $(this).find(':selected').data('harga') || 0;
            let parent = $(this).closest('.barang-detail');
            parent.find('.harga').val(harga); // tampilkan harga
            parent.find('.harga-hidden').val(harga); // kirim ke backend
        });


        // Hapus baris barang
        $(document).on('click', '.remove-barang', function () {
            if ($('.barang-detail').length > 1) {
                $(this).closest('.barang-detail').remove();
            }
        });

        // Submit form via AJAX
        $('#form-penjualan').on('submit', function (e) {
            e.preventDefault();
            var form = this;

            $.ajax({
                url: form.action,
                method: form.method,
                data: $(form).serialize(),
                success: function (response) {
                    if (response.status) {
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                        dataPenjualan.ajax.reload();
                    } else {
                        $('.error-text').text('');
                        $.each(response.msgField, function (prefix, val) {
                            $('#error-' + prefix).text(val[0]);
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: response.message
                        });
                    }
                }
            });
        });
    });

</script>