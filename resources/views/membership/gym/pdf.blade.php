<!DOCTYPE html>
<html>
<head>
    <title>Laporan Membership Gym</title>
<style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
        h2 {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Laporan Membership Body Zone</h1>
    <h4>{{ $judul }}</h4>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                @if($subKategori == 'Privat')
                    <th>Pelatih</th>
                @elseif($subKategori == 'Harian')
                    <th>Tgl Gym</th>
                @elseif($subKategori == 'Bulanan')
                    <th>Paket</th>
                    <th>Tgl Mulai</th>
                    <th>Tgl Selesai</th>
                @endif
                <th>Alamat</th>
                <th>No. Telp</th>
                <th>Harga</th>
                <th>Status Bayar</th>
                <th>Status Sesi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($memberships as $index => $m)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $m->customer->nama }}</td>

                    @if($subKategori == 'Privat')
                        <td>{{ $m->pelatih->nama ?? '-' }}</td>
                    @elseif($subKategori == 'Harian')
                        <td>{{ $m->tgl_datang }}</td>
                    @elseif($subKategori == 'Bulanan')
                        <td>{{ $m->paket->nama ?? '-' }}</td>
                        <td>{{ $m->tgl_mulai }}</td>
                        <td>{{ $m->tgl_selesai }}</td>
                    @endif

                    <td>{{ $m->customer->alamat }}</td>
                    <td>{{ $m->customer->no_telp }}</td>
                    <td> Rp {{ number_format($m->paket->harga ?? 0) }}</td>
                    <td> {{ $m->status == 'lunas' ? 'Lunas' : 'Belum Lunas' }}</td>
                     <td>{{ $m->status_selesai ? 'Selesai' : 'Aktif' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data membership gym untuk kategori ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>