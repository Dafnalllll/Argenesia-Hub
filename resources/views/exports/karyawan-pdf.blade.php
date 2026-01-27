<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Karyawan</title>
    <style>
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #333; padding: 6px; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>Data Karyawan</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Kode Karyawan</th>
                <th>Status</th>
                <th>Tanggal Masuk</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($karyawans as $i => $karyawan)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $karyawan->user->name ?? '-' }}</td>
                <td>{{ $karyawan->user->email ?? '-' }}</td>
                <td>{{ $karyawan->user->role->name ?? '-' }}</td>
                <td>{{ $karyawan->kode_karyawan }}</td>
                <td>{{ $karyawan->status_karyawan }}</td>
                <td>{{ $karyawan->tanggal_masuk }}</td>
                <td>{{ $karyawan->alamat }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
