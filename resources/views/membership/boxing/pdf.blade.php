<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Membership Boxing</title>
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
    
    @if(count($memberships) > 0)
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>

                @if($subKategori == 'Privat')
                    <th>Pelatih</th>
                @elseif($subKategori == 'Reguler')
                    <th>Paket</th>
                @elseif($subKategori == 'Insidental')
                    <th>Tgl Boxing</th>
                    <th>Pelatih</th>
                @endif

                <th>Alamat</th>
                <th>No. Telp</th>
                <th>Harga</th>
                <th>Status Pembayaran</th>
                <th>Status Sesi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($memberships as $index => $m)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $m->customer->nama }}</td>

                    @if($subKategori == 'Privat')
                        <td>{{ $m->pelatih->nama ?? '-' }}</td>
                    @elseif($subKategori == 'Reguler')
                        <td>{{ $m->paket->nama ?? '-' }}</td>
                    @elseif($subKategori == 'Insidental')
                        <td>{{ date('d M Y', strtotime($m->tgl_datang)) }}</td>
                        <td>{{ $m->pelatih->nama ?? '-' }}</td>
                    @endif

                    <td>{{ $m->customer->alamat }}</td>
                    <td>{{ $m->customer->no_telp }}</td>
                    <td>Rp {{ number_format($m->paket->harga ?? 0) }}</td>
                    <td>{{ ucfirst($m->status) }}</td>
                    <td>{{ $m->status_selesai ? 'Selesai' : 'Aktif' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p style="text-align: center;">Tidak ada data membership boxing untuk kategori ini.</p>
    @endif
</body>
</html>
