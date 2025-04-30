<form action="{{ url('/penjualan/ajax') }}" method="POST" id="form-penjualan">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Pembeli</label>
                    <input type="text" name="pembeli" class="form-control" required>
                    <small id="error-pembeli" class="error-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Tanggal Penjualan</label>
                    <input type="date" name="penjualan_tanggal" class="form-control" required>
                    <small id="error-penjualan_tanggal" class="error-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Barang</label>
                    <div id="barang-container">
                        <div class="barang-row row mb-2">
                            <div class="col-md-6">
                                <select name="barang_id[]" class="form-control" required>
                                    <option value="">- Pilih Barang -</option>
                                    @foreach($barang as $b)
                                    <option value="{{ $b->barang_id }}">{{ $b->barang_nama }}</option>
                                    @endforeach
                                </select>
                                <small class="error-text text-danger error-barang_id"></small>
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" min="1" required>
                                <small class="error-text text-danger error-jumlah"></small>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger remove-barang">X</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" id="add-barang">+ Tambah Barang</button>
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
        // Add new barang row
        $('#add-barang').click(function () {
            let row = `
                <div class="barang-row row mb-2">
                    <div class="col-md-6">
                        <select name="barang_id[]" class="form-control" required>
                            <option value="">- Pilih Barang -</option>
                            @foreach($barang as $b)
                            <option value="{{ $b->barang_id }}">{{ $b->barang_nama }}</option>
                            @endforeach
                        </select>
                        <small class="error-text text-danger error-barang_id"></small>
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" min="1" required>
                        <small class="error-text text-danger error-jumlah"></small>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-barang">X</button>
                    </div>
                </div>
            `;
            $('#barang-container').append(row);
        });

        // Remove barang row
        $(document).on('click', '.remove-barang', function () {
            $(this).closest('.barang-row').remove();
        });

        // Form validation + AJAX
        $("#form-penjualan").validate({
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
                            dataUser.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            if (response.msgField) {
                                $.each(response.msgField, function (prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
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
