@extends('layout.app')

@section('subtitle', 'Edit Kategori')
@section('content_header_title', 'Kategori')
@section('content_header_subtitle', 'Edit')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Edit Kategori</div>
            <div class="card-body">
                <form action="/kategori/update/{{$id_kategori}}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="kategori_kode">Kode Kategori</label>
                        <input type="text" name="kategori_kode" id="kategori_kode"
                            class="form-control @error('kategori_kode') is-invalid @enderror"
                            value="{{ old('kategori_kode', $kategori->kategori_kode) }}" required>
                        @error('kategori_kode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="kategori_nama">Nama Kategori</label>
                        <input type="text" name="kategori_nama" id="kategori_nama"
                            class="form-control @error('kategori_nama') is-invalid @enderror"
                            value="{{ old('kategori_nama', $kategori->kategori_nama) }}" required>
                        @error('kategori_nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="/kategori" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection