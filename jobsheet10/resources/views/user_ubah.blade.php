<!DOCTYPE html>
<html>
<head>
    <title>Ubah Data</title>
</head>
    <body>
        <h1>Form Ubah Data User</h1>
        <a href="/user">Kembali</a>
        <br><br>
        
        <form action="/user/ubah_simpan/{{ $data->user_id }}" method="post">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            
            <label>Username</label>
            <input type="text" name="username" value="{{ $data->username }}" placeholder="Masukkan Username">
            <br>
            <label for="">Nama</label>
            <input type="text" name="nama" value="{{ $data->nama }}" placeholder="Masukkan Nama">
            <br>
            <label for="">Password</label>
            <input type="password" name="password" value="{{ $data->password }}" placeholder="Masukkan Password">
            <br>
            <label for="">Level Pengguna</label>
            <input type="number" name="level_id" value="{{ $data->level_id }}" placeholder="Masukkan Level Pengguna">
            <br><br>
            <input type="submit" class="btn btn-success" value="Ubah">
        </form>
    </body>
</html>