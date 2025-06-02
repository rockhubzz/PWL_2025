<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Penjualan</h5>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered table-sm">
                <tr><th>Kode</th><td>{{ $penjualan->penjualan_kode }}</td></tr>
                <tr><th>Pembeli</th><td>{{ $penjualan->pembeli }}</td></tr>
                <tr><th>Tanggal</th><td>{{ $penjualan->penjualan_tanggal }}</td></tr>
                <tr><th>Total Penjualan</th><td>{{ 'Rp ' . number_format($penjualan->total_penjualan, 0, ',', '.') }}</td></tr>
            </table>
            <h5 class="mt-4">Detail Barang</h5>
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penjualan->detail as $item)
                        <tr>
                            <td>{{ $item->barang->barang_nama }}</td>
                            <td>{{ 'Rp ' . number_format($item->barang->harga_jual, 0, ',', '.') }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ 'Rp ' . number_format($item->harga, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
