@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Detail Kategori</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        @if(isset($kategori))
            <table class="table table-bordered table-striped table-hover table-sm">
                <tr>
                    <th>Kode Kategori</th>
                    <td>{{ $kategori->kategori_kode }}</td>
                </tr>
                <tr>
                    <th>Nama Kategori</th>
                    <td>{{ $kategori->kategori_nama }}</td>
                </tr>
            </table>
        @else
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                Data kategori tidak ditemukan.
            </div>
        @endif
        <a href="{{ url('kategori') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
