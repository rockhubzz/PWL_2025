@extends('layouts.template')
 
 @section('content')
     <div class="card card-outline card-primary">
         <div class="card-header">
             <h3 class="card-title">{{ $page->title }}</h3>
             <div class="card-tools">
                 <a class="btn btn-sm btn-primary mt-1" href="{{ url('kategori/create') }}">Tambah</a>
             </div>
         </div>
         <div class="card-body">
             @if (session('success'))
                 <div class="alert alert-success">{{ session('success') }}</div>
             @endif
             @if (session('error'))
                 <div class="alert alert-danger">{{ session('error') }}</div>
             @endif
             <table class="table table-bordered table-striped table-hover table-sm" id="table_kategori">
                 <thead>
                     <tr>
                         <th>ID</th>
                         <th>Kode</th>
                         <th>Nama</th>
                         <th>Aksi</th>
                     </tr>
                 </thead>
             </table>
         </div>
     </div>
 @endsection
 
 @push('css')
 @endpush
 
 @push('js')
     <script>
         $(document).ready(function() {
             var dataLevel = $('#table_kategori').DataTable({
                 serverSide: true,
                 ajax: {
                     "url": "{{ url('kategori/list') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data": function (d) {
                    d.kategori_id = $('#kategori_id').val();
                    d._token = "{{ csrf_token() }}";
                }

                 },
                 columns: [{
                         data: "DT_RowIndex",
                         className: "text-center",
                         orderable: false,
                         searchable: false
                     },
                     {
                         data: "kategori_kode",
                         className: "",
                         orderable: true,
                         searchable: true
                     },
                     {
                         data: "kategori_nama",
                         className: "",
                         orderable: true,
                         searchable: true
                     },
                     {
                         data: "aksi",
                         className: "",
                         orderable: false,
                         searchable: false
                     }
                 ]
             });
         });
     </script>
 @endpush