@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Profil Saya</h3>
        </div>
        <div class="card-body">
            <div class="text-center mb-3">
                <a onclick="modalAction('{{ url('profile/update_foto') }}')" class="profile-pic-wrapper position-relative d-inline-block">
                    <div class="image position-relative">
                        <img src="{{ asset('pfp/' . (Auth::user()->foto_profil ?? 'default-profile.png')) }}"
                          class="img-circle elevation-2"
                          alt="User Image"
                          style="width: 125px; height: 125px; object-fit: cover; margin-bottom: 10%;">
                      </div>
                    <div class="profile-pic-overlay">
                        Klik untuk ganti foto
                    </div>
                </a>
                <h3>{{ $user->nama }}</h3>
            </div>
            <div class="d-flex justify-content-center">
                <table class="table table-bordered table-striped table-hover table-sm" style="width: 30%">
                    <tr>
                        <th>ID</th>
                    <td>{{ $user->user_id }}</td>
                </tr>
                <tr>
                    <th>Level</th>
                    <td>{{ $user->level->level_nama }}</td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <td>{{ $user->nama }}</td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td>{{ $user->username }}</td>
                </tr>
                {{-- <tr>
                    <th>Password</th>
                    <td>********</td>
                </tr> --}}
            </table>
        </div>
        <div class="d-flex justify-content-center">
        <button onclick="modalAction('{{ url('user/' . $user->user_id . '/edit_ajax') }}')" class="btn btn-success mx-2" style="align-items: center">Ubah Data</button>
        <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger mx-2" style="align-items: center">Log out</button>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
<style>
     .profile-pic-wrapper {
        position: relative;
        display: inline-block;
    }

    .profile-pic {
        transition: 0.3s ease-in-out;
    }

    .profile-pic-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.3);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }

    .profile-pic-wrapper:hover .profile-pic {
        filter: brightness(60%);
    }

    .profile-pic-wrapper:hover .profile-pic-overlay {
        opacity: 1;
    }
</style>
@endpush

@push('js')
<script>
function modalAction(url = '') {
         console.log("Fetching modal from:", url);
         $('#myModal').load(url, function(response, status, xhr) {
             if (status == "error") {
                 console.log("Error loading modal:", xhr.status, xhr.statusText);
             } else {
                 $('#myModal').modal('show');
             }
         });
     }</script>
@endpush