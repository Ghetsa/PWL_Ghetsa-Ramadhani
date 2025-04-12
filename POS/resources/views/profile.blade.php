<form id="form-update-foto" enctype="multipart/form-data">
  @csrf
  <div class="form-group">
    <label for="foto">Ubah Foto Profil</label>
    <input type="file" name="foto" class="form-control" accept="image/*">
  </div>
  <button type="submit" class="btn btn-primary">Upload</button>
</form>

<img src="{{ Auth::user()->foto ? asset('storage/foto_profil/' . Auth::user()->foto) : asset('default-avatar.png') }}" 
     alt="Foto Profil" class="img-thumbnail mt-3" width="150">
<script>
  $('#form-update-foto').on('submit', function (e) {
    e.preventDefault();
    let formData = new FormData(this);

    $.ajax({
      url: '{{ route("update.foto") }}',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function (res) {
        if (res.status) {
          Swal.fire('Sukses', res.message, 'success');
          // Update tampilan foto tanpa reload
          $('img[alt="Foto Profil"]').attr('src', res.foto_url + '?' + new Date().getTime());
        }
      },
      error: function (xhr) {
        Swal.fire('Gagal', 'Gagal upload foto. Pastikan file valid!', 'error');
      }
    });
  });
</script>
