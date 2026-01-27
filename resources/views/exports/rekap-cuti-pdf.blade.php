<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Nama Karyawan</th>
            <th>Tipe</th>
            <th>Tanggal Pengajuan</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cutis as $item)
        <tr>
            <td>{{ $item->karyawan->user->name ?? '-' }}</td>
            <td>{{ $item->tipeCuti->nama_cuti ?? '-' }}</td>
            <td>{{ $item->created_at->format('Y-m-d') }}</td>
            <td>{{ $item->tanggal_mulai }}</td>
            <td>{{ $item->tanggal_selesai }}</td>
            <td>{{ $item->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
