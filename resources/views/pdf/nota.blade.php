<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            width: 100%;
            border-spacing: 0;
            margin: 20px 0px;
        }

        table.item td, table.item th {
            border-width: 1px;
            border-color: black;
            border-style: solid;
        }

        table.item td,table.item th  {
            padding: 5px;
        }

        table.item td:first-child {
            width: 40px;
            text-align: center;
        }

        .ttd td {
            text-align: center;
        }
    </style>
</head>
<body>
    <img src="{{ public_path('/files/toko/' . $nota->toko->kop) }}" alt="" style="width: 100%; margin-bottom: 30px">

    <div>
        <table style="width: unset; margin: auto">
            <tr>
                <td>Toko</td>
                <td style="width: 30px; text-align: center">:</td>
                <td>{{ $nota->toko->nama }}</td>
            </tr>
            <tr>
                <td>Nama Petugas</td>
                <td style="width: 30px; text-align: center">:</td>
                <td>{{ $pedagang->nama }}</td>
            </tr>
            <tr>
                <td>No. Telpon Toko</td>
                <td style="width: 30px; text-align: center">:</td>
                <td>{{ $nota->toko->kontak }}</td>
            </tr>
            <tr>
                <td>Alamat Toko</td>
                <td style="width: 30px; text-align: center">:</td>
                <td>{{ $nota->toko->alamat }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td style="width: 30px; text-align: center">:</td>
                <td>{{ Carbon\Carbon::parse($nota->created_at)->isoFormat('D MMMM YYYY') }}</td>
            </tr>
        </table>
    </div>

    <table>
        <tr>
            <td>No. Nota</td>
            <td style="width: 30px">:</td>
            <td>{{ $nota->nomor }}</td>

            <td>No. HP</td>
            <td style="width: 30px">:</td>
            <td>{{ $nota->customer->no_hp }}</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td style="width: 30px">:</td>
            <td>{{ $nota->customer->nama }}</td>

            <td>Alamat</td>
            <td style="width: 30px">:</td>
            <td>{{ $nota->customer->alamat }}</td>
        </tr>
        <tr>
            <td>Jenis Gabah</td>
            <td style="width: 30px">:</td>
            <td>{{ $nota->gabah->jenis }}</td>

            <td></td>
            <td style="width: 30px"></td>
            <td></td>
        </tr>
    </table>

    <table class="item">
        <tr>
            <th>No</th>
            <th>Jumlah</th>
            <th>Berat (kg)</th>
        </tr>
        @foreach ($nota->items as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>{{ $item->berat }}</td>
            </tr>
        @endforeach
        <tr>
            <th>Total</th>
            <td>{{ $nota->items->sum('jumlah') }}</td>
            <td>{{ $nota->items->sum('berat') }} kg</td>
        </tr>
    </table>

    <table>
        <tr>
            <td style="width: 100px">Total</td>
            <td style="width: 30px">:</td>
            <td>Rp. {{ number_format($nota->total_harga) }}</td>
        </tr>
        <tr>
            <td style="width: 100px">Catatan</td>
            <td style="width: 30px">:</td>
            <td>{{ $nota->catatan }}</td>
        </tr>
    </table>

    <div style="height: 50px"></div>

    <table class="ttd">
        <tr>
            <td>Tanda Terima</td>
            <td>Hormat Kami,</td>
        </tr>
        <tr>
            <td>
                <img src="{{ public_path('/files/nota/' . str_replace('/', '-', $nota->nomor) . '/' . $nota->ttd) }}" alt="" style="height: 70px">
            </td>
            <td>
                <img src="{{ public_path('/files/pedagang/' . $pedagang->ttd) }}" alt="" style="height: 70px">
            </td>
        </tr>
        <tr>
            <td>{{ $nota->customer->nama }}</td>
            <td>{{ $pedagang->nama }}</td>
        </tr>
    </table>
</body>
</html>
