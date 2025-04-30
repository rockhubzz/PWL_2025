@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <button onclick="modalAction('{{ url('/penjualan/import') }}')" class="btn btn-info">Import Penjualan</button>
            <a href="{{ url('/penjualan/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export Penjualan Excel</a>
            <a href="{{ url('/penjualan/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export Penjualan PDF</a>
            <button onclick="modalAction('{{ url('/penjualan/create_ajax') }}')" class="btn btn-sm btn-success">Tambah Penjualan</button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <table class="table table-bordered table-striped table-hover table-sm" id="table_penjualan">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode Penjualan</th>
                    <th>Pembeli</th>
                    <th>Total Penjualan</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"></div>
@endsection

@push('js')
<script>
function modalAction(url = '') {
    $('#myModal').load(url, function(response, status, xhr) {
        if (status === "error") {
            console.error("Error loading modal:", xhr.statusText);
        } else {
            $('#myModal').modal('show');
        }
    });
}

$(document).ready(function () {
    $('#table_penjualan').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('penjualan/list') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        },
        columns: [
    {
        data: 'penjualan_id',
        orderable: false,
        searchable: false,
        className: 'text-center'
    },
    { data: 'penjualan_kode' },
    { data: 'pembeli' },
    {
        data: 'total_penjualan',
        render: function (data) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(data);
        }
    },
    { data: 'penjualan_tanggal' },
    {
        data: 'aksi',
        orderable: false,
        searchable: false
    }
]
    });
});
</script>
@endpush
