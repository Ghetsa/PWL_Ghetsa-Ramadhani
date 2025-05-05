@empty($penjualan)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/penjualan') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/penjualan/' . $penjualan->penjualan_id . '/update_ajax') }}" method="POST"
        id="form-edit-penjualan">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Penjualan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <!-- Pengguna -->
                    <div class="form-group">
                        <label>Pengguna</label>
                        <select class="form-control" id="user_id" name="user_id" required>
                            <option value="">- Pilih Pengguna -</option>
                            @foreach($user as $item)
                                <option value="{{ $item->user_id }}" @if($item->user_id == $penjualan->user_id) selected @endif>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-user_id" class="error-text form-text text-danger"></small>
                    </div>

                    <!-- Pembeli -->
                    <div class="form-group">
                        <label>Pembeli</label>
                        <input type="text" class="form-control" id="pembeli" name="pembeli"
                            value="{{ $penjualan->pembeli }}" required>
                        <small id="error-pembeli" class="error-text form-text text-danger"></small>
                    </div>

                    <!-- Kode Penjualan -->
                    <div class="form-group">
                        <label>Kode Penjualan</label>
                        <input type="text" class="form-control" id="penjualan_kode" name="penjualan_kode"
                            value="{{ $penjualan->penjualan_kode }}" required>
                        <small id="error-penjualan_kode" class="error-text form-text text-danger"></small>
                    </div>

                    <!-- Tanggal Penjualan -->
                    <div class="form-group">
                        <label>Tanggal Penjualan</label>
                        <input type="datetime-local" name="penjualan_tanggal" id="penjualan_tanggal" class="form-control"
                            value="{{ \Carbon\Carbon::parse($penjualan->penjualan_tanggal)->format('Y-m-d\TH:i') }}"
                            required>
                        <small id="error-penjualan_tanggal" class="error-text text-danger"></small>
                    </div>

                    <hr>
                    <h5 class="mt-4">Detail Penjualan</h5>
                    <div id="barangDetails">
                        @foreach ($penjualan->detail as $index => $detail)
                            <div class="barang-detail row mb-2 align-items-end">
                                <div class="form-group col-md-4">
                                    <label>Barang</label>
                                    <select name="barang_id[]" class="form-control barang-select" required>
                                        <option value="">- Pilih Barang -</option>
                                        @foreach ($barang as $b)
                                            <option value="{{ $b->barang_id }}" data-harga="{{ $b->harga_jual }}"
                                                @if($b->barang_id == $detail->barang_id) selected @endif>
                                                {{ $b->barang_nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Harga</label>
                                    <input type="number" class="form-control harga" value="{{ $detail->harga }}" disabled
                                        required>
                                    <input type="hidden" name="harga[]" class="harga-hidden" value="{{ $detail->harga }}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Jumlah</label>
                                    <input type="number" name="jumlah[]" class="form-control" value="{{ $detail->jumlah }}"
                                        required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="d-block">&nbsp;</label>
                                    <button type="button" class="btn btn-danger remove-barang"
                                        style="height: 38px;">Hapus</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
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
            $("#form-edit-penjualan").validate({
                rules: {
                    user_id: { required: true, number: true },
                    penjualan_kode: { required: true },
                    penjualan_tanggal: { required: true, date: true },
                    @foreach ($penjualan->detail as $index => $detail)
                                "detail[{{ $index }}][barang_id]": { required: true, number: true },
                        "detail[{{ $index }}][jumlah]": { required: true, number: true, min: 1 },
                        "detail[{{ $index }}][harga]": { required: true, number: true, min: 0 },
                    @endforeach
                    },
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
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
                                $('#error-' + prefix.replaceAll('.', '-')).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            }
                });
            });
    </script>
@endempty