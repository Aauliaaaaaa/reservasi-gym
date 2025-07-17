<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Customer</title>
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
    <h2 style="text-align: center;">Laporan Customer Body Zone</h2>
    <p class="subjudul">Periode: {{ $bulanNama }} {{ $tahunNama ?? '' }}</p>

    @if(count($customers) > 0)
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>No Telp</th>
                    <th>Alamat</th>
                    <th>Tanggal Daftar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $index => $c)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $c->nama }}</td>
                        <td>{{ $c->jenis_kelamin }}</td>
                        <td>{{ $c->no_telp }}</td>
                        <td>{{ $c->alamat }}</td>
                        <td>{{ $c->created_at->format('d-m-Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center;">Tidak ada data customer untuk bulan ini.</p>
    @endif
</body>
</html>
