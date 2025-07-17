<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Membership</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Laporan Data Membership Body Zone</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Customer</th>
                <th>Layanan</th>
                <th>Paket</th>
                <th>Pelatih</th>
                <th>Alamat</th>
                <th>No. Telp</th>
                <th>Harga</th>
                <th>Status Bayar</th>
                <th>Status Sesi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($memberships as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->created_at->format('d M Y') }}</td>
                    <td>{{ $item->customer->nama ?? 'N/A' }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{ $item->paket->nama ?? $item->sub_kategori }}</td>
                    <td>{{ $item->pelatih->nama ?? '' }}</td>
                    <td>{{ $item->customer->alamat }}</td>
                    <td>{{ $item->customer->no_telp }}</td>
                    <td>Rp {{ number_format($item->paket->harga ?? 0) }}</td>
                    <td>{{ $item->status == 'lunas' ? 'Lunas' : 'Belum Lunas' }}</td>
                    <td>{{ $item->status_selesai ? 'Selesai' : 'Aktif' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
