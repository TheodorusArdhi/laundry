<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/washing_machine.ico') }}" />
    <title>Nota - Sinar Laundry</title>

    <style>
        html,
        body {
            margin: 10px;
            padding: 10px;
            font-family: sans-serif;
        }
        h1,h2,h3,h4,h5,h6,p,span,label {
            font-family: sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0px !important;
        }
        table thead th {
            height: 28px;
            text-align: left;
            font-size: 16px;
            font-family: sans-serif;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 14px;
        }

        .heading {
            font-size: 24px;
            margin-top: 12px;
            margin-bottom: 12px;
            font-family: sans-serif;
        }
        .small-heading {
            font-size: 18px;
            font-family: sans-serif;
        }
        .total-heading {
            font-size: 18px;
            font-weight: 700;
            font-family: sans-serif;
        }
        .order-details tbody tr td:nth-child(1) {
            width: 20%;
        }
        .order-details tbody tr td:nth-child(3) {
            width: 20%;
        }

        .text-start {
            text-align: left;
        }
        .text-end {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .company-data span {
            margin-bottom: 4px;
            display: inline-block;
            font-family: sans-serif;
            font-size: 14px;
            font-weight: 400;
        }
        .no-border {
            border: 1px solid #fff !important;
        }
        .bg-primary {
            background-color: #0d6efd;
            color: #fff;
        }
    </style>
</head>
<body>
    <table class="order-details">
        <thead>
            <tr>
                <th colspan="4" class="text-center company-data">
                    <h2>Sinar Laundry</h2>
                    <span>Telepon: </span> <br>
                    <span>Instagram: </span> <br>
                    <span>Alamat: Solo</span> <br>
                </th>
            </tr>
            <tr class="bg-primary">
                <th width="50%" colspan="2">Detail Transaksi</th>
                <th width="50%" colspan="2">Customer</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Nomor Nota</td>
                <td>{{ $transaksi->no_transaksi }}</td>

                <td>Nama</td>
                <td>{{ $transaksi->user->nama }}</td>
            </tr>
            <tr>
                <td>Operator</td>
                <td>{{ $transaksi->admin->nama }}</td>

                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Tanggal Transaksi</td>
                <td>{{ $transaksi->created_at-> translatedFormat('l, d F Y H:i:s') }}</td>

                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Status Pembayaran</td>
                <td>{{ $transaksi->statusPembayaran->nama }}</td>

                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th class="no-border text-start total-heading" colspan="5">
                    Detail Layanan
                </th>
            </tr>
            <tr class="bg-primary">
                <th>No</th>
                <th>Layanan</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
        </thead>
    <?php
        $i=1;
    ?>
        <tbody >
            @foreach ($transaksiDetail as $index => $item )
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $item -> layanan -> nama }}</td>
                <td>{{ rupiah($item -> harga) }}</td>
                @if($item -> layanan -> satuan == "kg")
                <td>{{ $item -> jumlah }} Kg</td>
                @else
                <td>{{ $item -> jumlah }}</td>
                @endif
                <td>{{ rupiah($item -> subtotal) }}</td>
            </tr>
            @endforeach
            <tr>
            @if ($transaksi->id_pengumuman == null)
                <td colspan="4" class="total-heading">Total Tagihan </td>
                <td colspan="1" class="total-heading">{{ rupiah($transaksi->total_tagihan) }}</td>
            </tr>
            @else
                <td colspan="4" class="total-heading">Total Harga </td>
                <td colspan="1" class="total-heading">{{ rupiah($transaksi->total_harga) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="total-heading"><small>Diskon {{ $transaksi->pengumuman->judul }} {{ $transaksi->pengumuman->diskon }}%</small></td>
                @php
                $totHarga = $transaksi->total_harga - $transaksi->total_tagihan;
                @endphp
                <td colspan="1" class="total-heading"> <small>-{{ rupiah($totHarga) }}</small></td>
            </tr>
            <tr>
                <td colspan="4" class="total-heading">Total Tagihan </td>
                <td colspan="1" class="total-heading">{{ rupiah($transaksi->total_tagihan) }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <br>
    <p class="text-center">
        Terima Kasih Telah Menggunakan Layanan Kami - Sinar Laundry
    </p>

</body>
</html>