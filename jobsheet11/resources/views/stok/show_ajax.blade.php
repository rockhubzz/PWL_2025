<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Data Stok</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered table-striped table-hover table-sm">
                <tr>
                    <th>ID</th>
                    <td>{{ $stok->stok_id }}</td>
                </tr>
                <tr>
                    <th>Nama barang</th>
                    <td>{{ $stok->barang->barang_nama }}</td>
                </tr>
                <tr>
                    <th>User</th>
                    <td>{{ $stok->user->nama }}</td>
                </tr>
                <tr>
                    <th>Supplier</th>
                    <td>{{ $stok->supplier->supplier_nama }}</td>
                </tr>
                <tr>
                    <th>Jumlah stok</th>
                    <td>{{$stok->stok_jumlah}}</td>
                </tr>
                <tr>
                    <th>Tanggal stok</th>
                    <td>{{$stok->stok_tanggal}}</td>
                </tr>
            </table>
    </div>
</div>