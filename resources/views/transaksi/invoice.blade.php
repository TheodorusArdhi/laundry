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
        .mid-heading {
            font-size: 16px;
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
        .fs {
            font-size: 12px;
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

        .bg-laundry {
            background-color: #C9D30a;
            color: #000;
        }
        
        .bg-primary-light {
            background-color: #eef2f9;
        }

        .bg-laundry-light {
            background-color: #feffef;
        }

    </style>
</head>
<body>
    <table class="order-details">
        <thead>
            <tr>
                <th colspan="4" class="text-center company-data">
                    <h2>Sinar Laundry {{ $cabang->nama }}</h2>
                    <span>Alamat: {{ $cabang->alamat }}</span> <br>
                    <span>Telepon: {{ $cabang->no_telp }}</span>
                </th>
            </tr>
            <tr class="bg-laundry">
                <th colspan="2">Detail Transaksi</th>
                <th colspan="2">Customer</th>
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

                <td>Nomor Telepon</td>
                <td>{{ str_pad(substr($transaksi->user->no_telp, -4), strlen($transaksi->user->no_telp), '*', STR_PAD_LEFT) }}</td>
            </tr>
            <tr>
                <td>Tanggal Transaksi</td>
                <td>{{ $transaksi->created_at-> translatedFormat('l, d F Y H:i') }} WIB</td>

                @php
                    $level = App\Models\User::where('id_user', $transaksi->id_user)->first()->level;
                @endphp
                @if ($level == "anggota")
                <td>Poin Masuk + kunjungan(100)</td>
                <td>{{ $transaksi->poin_masuk }}</td>
                @else
                    
                @endif
            </tr>
            <tr>
                <td>Estimasi Selesai</td>
                <td>{{ $transaksi->tgl_selesai-> translatedFormat('l, d F Y')}} {{ $transaksi->created_at-> translatedFormat('H:i') }} WIB</td>
                
                <td></td>
                <td></td>
            </tr>
            @if ($transaksi -> tgl_ambil != null)
            <tr>
                <td>Tanggal Ambil</td>
                <td>{{ $transaksi->tgl_ambil-> translatedFormat('l, d F Y')}} {{ $transaksi->updated_at-> translatedFormat('H:i') }} WIB</td>

                <td></td>
                <td></td>
            </tr>
            @endif
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
                <th class="no-border text-start total-heading" colspan="5">Detail Layanan</th>
            </tr>
            <tr class="bg-laundry">
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
            <tr class="bg-laundry-light">
                <td colspan="4" class="mid-heading"><small>Total Harga</small></td>
                <td colspan="1" class="mid-heading"><small>{{ rupiah($transaksi->total_harga) }}</small></td>
            </tr>
            @if ($transaksi->poin_keluar != 0)
            <tr class="bg-laundry-light">
                <td colspan="4" class="mid-heading"><small>Poin Keluar</small></td>
                <td colspan="1" class="mid-heading"><small>-{{ rupiah($transaksi->poin_keluar) }}</small></td>
            </tr>
            @endif
            @if ($transaksi->id_pengumuman != null)
            <tr class="bg-laundry-light">
                <td colspan="4" class="mid-heading"><small>Diskon {{ $transaksi->pengumuman->judul }} {{ $transaksi->pengumuman->diskon }}%</small></td>
                @php
                $diskon = $transaksi->total_harga * ($transaksi->diskon / 100);
                @endphp
                <td colspan="1" class="mid-heading"><small>-{{ rupiah($diskon) }}</small></td>
            </tr>
            @endif

            <tr class="bg-laundry-light">
                <td colspan="4" class="total-heading">Total Tagihan</td>
                <td colspan="1" class="total-heading">{{ rupiah($transaksi->total_tagihan) }}</td>
            </tr>
            <tr class="bg-laundry-light">
                <td colspan="4" class="mid-heading"><small>Diterima</small></td>
                <td colspan="1" class="mid-heading"><small>{{ rupiah($transaksi->diterima) }}</small></td>
            </tr>
            <tr class="bg-laundry-light">
                <td colspan="4" class="total-heading">Kembali</td>
                <td colspan="1" class="total-heading">
                    @if(($transaksi->diterima - $transaksi->total_tagihan) <1)
                        {{ rupiah(0) }}
                    @else
                        {{ rupiah($transaksi->diterima - $transaksi->total_tagihan) }}
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    <p class="text-start fs">
        SYARAT DAN KETENTUAN :
        <br>    1. Pengambilan laundry harus disertai nota.
        <br>    2. Komplain kami layani 1 X 24 jam.
        <br>    KAMI TIDAK BERTANGGUNG JAWAB ATAS :
        <br>    1. Menyusut atau warna luntur karena sifat bahan.
        <br>    2. Hilangnya benda kecil atau benda berharga yang tertinggal bersama pakaian/barang.
        <br>    3. Pengambilan laundry lebih dari 30 hari dari tanggal selesai.
    </p>
    <p class="text-center">
        Terima Kasih Telah Menggunakan Layanan Kami - Sinar Laundry
    </p>

</body>
</html>