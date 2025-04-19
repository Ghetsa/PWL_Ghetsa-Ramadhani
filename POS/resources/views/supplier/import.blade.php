<form action="{{ url('supplier/import_ajax') }}" method="POST" id="form-import" enctype="multipart/form-data">
  @csrf
  <div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Import Data Supplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Download Template</label>
          <a href="{{ asset('template_supplier.xlsx') }}" class="btn btn-info btn-sm" download>
            <i class="fa fa-file-excel"></i> Download
          </a>
          <small id="error-supplier_id" class="error-text form-text text-danger"></small>
        </div>
        <div class="form-group">
          <label for="file_supplier" class="font-weight-bold">Pilih File</label>
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="file_supplier" name="file_supplier">
            <label class="custom-file-label" for="file_supplier">Choose file</label>
          </div>
          <small id="error-file_supplier" class="error-text form-text text-danger"></small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
        <button type="submit" class="btn btn-primary">Upload</button>
      </div>
    </div>
  </div>
</form>
<script src="{{ asset('adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
  $(document).ready(function () {
    bsCustomFileInput.init();
  });
</script>
<script>
  $(document).ready(function () {
    $("#form-import").validate({
      rules: {
        file_supplier: { required: true, extension: "xlsx" }
      },
      submitHandler: function (form) {
        var formData = new FormData(form); // Jadikan form ke FormData untuk menghandle file
        $.ajax({
          url: form.action,
          type: form.method,
          data: formData, // Data yang dikirim berupa FormData
          processData: false, // setting processData dan contentType ke false, untuk menghandle file
          contentType: false,
          success: function (response) {
            if (response.status) { // jika sukses
              $('#myModal').modal('hide');
              Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: response.message
              });
              dataSupplier.ajax.reload(); // reload datatable
            } else { // jika error
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