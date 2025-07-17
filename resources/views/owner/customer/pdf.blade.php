<!DOCTYPE html>
<html>
<head>
    <title>{{ $judul }}</title>
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
        .subjudul {
            text-align: center;
            font-size: 14px;
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <h2>{{ $judul }}</h2>
    <p class="subjudul">Periode: {{ $bulanNama }} {{ $tahun ?? '' }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>No. Telp</th>
                <th>Alamat</th>
                <th>Tanggal Daftar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $index => $c)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $c->nama }}</td>
                    <td>{{ $c->jenis_kelamin }}</td>
                    <td>{{ $c->no_telp }}</td>
                    <td>{{ $c->alamat }}</td>
                    <td>{{ $c->created_at->format('d-m-Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Data tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
