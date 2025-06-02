@extends('layouts.template')
@section('content')

<h4 style="text-align:center">Selamat Datang, {{Auth::user()->nama}}</h2>

    <div class="card bg-yellow-100 shadow p-4 rounded-2xl col-span-2">
        <h4 class="text-lg font-semibold mb-2">Total Penjualan</h4>
        <h1 class="text-3xl font-bold text-green-800">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</h1>
    </div>

    <div class="card bg-yellow-100 shadow p-4 rounded-2xl col-span-2">
        <h4 class="text-lg font-semibold mb-4">5 Barang Terlaris</h4>
        <div class="overflow-x-auto">
            <table class="table table-bordered w-full text-center">
                <thead class="thead-light">
                    <tr>
                        <th class="px-4 py-2">Kode Barang</th>
                        <th class="px-4 py-2">Nama Barang</th>
                        <th class="px-4 py-2">Total Terjual</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($topBarang as $index => $barang)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $barang->barang_kode }}</td>
                            <td class="px-4 py-2">{{ $barang->barang_nama }}</td>
                            <td class="px-4 py-2">{{ $barang->total_terjual }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-2 text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="card bg-yellow-100 shadow p-4 rounded-2xl col-span-2">
        <h4 class="text-lg font-semibold mb-2">Barang Dengan Stok < 20</h4>
        <table class="table table-bordered w-full text-center">
            <thead class="thead-light">
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Stok</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lowStockItems as $barang)
                    <tr>
                        <td>{{ $barang->barang_kode }}</td>
                        <td>{{ $barang->barang_nama }}</td>
                        <td>{{ $barang->total_stok == 0 ? 'Habis' : $barang->total_stok }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Semua stok aman</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="card bg-yellow-100 shadow p-4 rounded-2xl col-span-2">
            <h4 class="text-lg font-semibold mb-2">Jumlah User Terdaftar</h4>
                <table class="table table-bordered w-full">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center" style="width: 60px;">#</th>
                            <th class="text-center">Level</th>
                            <th class="text-center">Jumlah Pengguna</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($userCountsByRole as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">{{ $item->level->level_nama }}</td>
                                <td class="text-center">{{ number_format($item->total, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Tidak ada data pengguna</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
    </div>
</div>



@endsection
