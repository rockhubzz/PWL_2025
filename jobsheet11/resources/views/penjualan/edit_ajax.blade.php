@empty($penjualan)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
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
    <form action="{{ url('/penjualan/' . $penjualan->penjualan_id . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Penjualan</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pembeli</label>
                        <input value="{{ $penjualan->pembeli }}" type="text" name="pembeli" class="form-control" required>
                        <small id="error-pembeli" class="error-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Penjualan</label>
                        <input value="{{ $penjualan->penjualan_tanggal }}" type="date" name="penjualan_tanggal" class="form-control" required>
                        <small id="error-penjualan_tanggal" class="error-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Barang</label>
                        <div id="barang-container">
                            @foreach($penjualan->detail as $d)
                                <div class="barang-row row mb-2">
                                    <div class="col-md-6">
                                        <select name="barang_id[]" class="form-control" required>
                                            <option value="">- Pilih Barang -</option>
                                            @foreach($barang as $b)
                                                <option value="{{ $b->barang_id }}" {{ $b->barang_id == $d->barang_id ? 'selected' : '' }}>
                                                    {{ $b->barang_nama }}
                                                </option>
                                                {{-- <input type="hidden" name="harga_jual[]" value="{{ $b->harga_jual }}"> --}}
                                            @endforeach
                                        </select>
                                        <small class="error-text text-danger error-barang_id"></small>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" name="jumlah[]" class="form-control" value="{{ $d->jumlah }}" min="1" required>
                                        <small class="error-text text-danger error-jumlah"></small>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger remove-barang">X</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-secondary" id="add-barang">+ Tambah Barang</button>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>

    <script>
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

        $(document).on('click', '.remove-barang', function () {
            $(this).closest('.barang-row').remove();
        });

        $("#form-edit").validate({
            rules: {
                pembeli: { required: true },
                penjualan_tanggal: { required: true }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message });
                            dataUser.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({ icon: 'error', title: 'Terjadi Kesalahan', text: response.message });
                        }
                    }
                });
                return false;
            }
        });
    </script>
@endempty
