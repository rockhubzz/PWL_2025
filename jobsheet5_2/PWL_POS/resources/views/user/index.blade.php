@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{$page->title}}</h3>
        <div class="card-tools">
            <a href="{{url('/user/create')}}" class="btn btn-sm btn-primary mt-1">Tambah</a>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{session('success')}}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{session('error')}}</div>
        @endif
        <table class="table table-bordered table-striped table-hover table-sm" id="table_user">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Level Pengguna</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function(){
        var dataUser = $('#table_user').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                "url": "{{url('user/list')}}",
                "dataType": "json",
                "type": "POST",
                "data": function (d) {
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "username",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "nama",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "level.level_nama", 
                    orderable: false,
                    searchable: false
                },
                {
                    data: "aksi",
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
</script>
@endpush
