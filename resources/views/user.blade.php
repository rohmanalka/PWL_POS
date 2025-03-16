<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data User</title>
</head>
<body>
    <h1>Data User</h1>
    <a href="/user/tambah">+ Tambah Data</a>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            {{-- <td>ID</td>
            <td>Username</td>
            <td>Nama</td>
            <td>ID Level Pengguna</td> --}}
            <td>Jumlah Pengguna</td>
        </tr>
        <tr>
            {{-- <td>{{$data->user_id}}</td>
            <td>{{$data->username}}</td>
            <td>{{$data->nama}}</td>
            <td>{{$data->level_id}}</td> --}}
            <td>{{$data}}</td>
        </tr>
    </table>
</body>
</html>