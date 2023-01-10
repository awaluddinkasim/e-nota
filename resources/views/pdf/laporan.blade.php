<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            border-spacing: 0;
            width: 100%;
        }

        td, th {
            border: solid 1px black;
            padding: 5px;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <th>Nomor Nota</th>
            <th>Jenis Gabah</th>
            <th>Pelanggan</th>
            <th>Total Harga</th>
            <th>Tanggal</th>
        </tr>
        @forelse ($daftarNota as $nota)
            <tr>
                <td>{{ $nota->nomor }}</td>
                <td>{{ $nota->gabah->jenis }}</td>
                <td>{{ $nota->customer->nama }}</td>
                <td>Rp. {{ number_format($nota->items->sum('harga')) }}</td>
                <td>{{ $nota->tanggal }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align: center">Tidak ada nota</td>
            </tr>
        @endforelse
    </table>
</body>

</html>
