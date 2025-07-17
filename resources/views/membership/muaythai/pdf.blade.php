<!DOCTYPE html>
<html>
<head>
    <title>Laporan Membership Muay Thai</title>
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
                
                {{-- Sesuaikan kolom header dengan sub-kategori Boxing --}}
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
            @forelse($memberships as $index => $m)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $m->customer->nama }}</td>

                    {{-- Tampilkan data sesuai sub-kategori --}}
                    @if($subKategori == 'Privat')
                        <td>{{ $m->pelatih->nama ?? '-' }}</td>
                    @elseif($subKategori == 'Reguler')
                        <td>{{ $m->paket->nama ?? '-' }}</td>
                    @elseif($subKategori == 'Insidental')
                        <td>{{ \Carbon\Carbon::parse($m->tgl_datang)->format('d M Y') }}</td>
                        <td>{{ $m->pelatih->nama ?? '-' }}</td>
                    @endif

                    <td>{{ $m->customer->alamat }}</td>
                    <td>{{ $m->customer->no_telp }}</td>
                    {{-- Ambil harga langsung dari relasi paket --}}
                    <td>Rp {{ number_format($m->paket->harga ?? 0) }}</td>
                    <td>{{ ucwords($m->status) }}</td>
                    <td>{{ $m->status_selesai ? 'Selesai' : 'Aktif' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center;">Data tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
