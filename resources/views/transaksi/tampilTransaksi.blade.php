<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template.head')
        <title>Transaksi - Sinar Laundry</title>
    </head>
    <body class="sb-nav-fixed">
        @include('template.topNav')
        <div id="layoutSidenav">
            @include('template.sideNav')
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Transaksi {{ $title }}</h1>
                        <a class="btn btn-success" href="/tambahTransaksi" role="button">Tambah</a>
                        <div class="card mb-4 mt-2 ">                            
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                <a> <b class="fw-semibold"></b></a>
                            </div>                            
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead >
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Transaksi</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Nama</th>
                                            <th>Status Transaksi</th>
                                            <th>Status Pembayaran</th>
                                            <th>Harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot >
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Transaksi</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Nama</th>
                                            <th>Status Transaksi</th>
                                            <th>Status Pembayaran</th>
                                            <th>Harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <?php
                                        $i=1;
                                    ?>
                                    <tbody >
                                        @foreach ($transaksi as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $item -> no_transaksi }}</td>
                                            <td>{{ $item -> tgl_masuk -> translatedFormat('l, d F Y') }}</td>
                                            <td>{{ $item -> tgl_selesai -> translatedFormat('l, d F Y') }}</td>
                                            <td>{{ $item -> user -> nama }}</td>
                                            <td>
                                                @if($item -> id_status_transaksi == "3")
                                                <span class="badge text-bg-secondary">{{ $item -> statusTransaksi -> nama }}</span>
                                                @elseif ($item -> id_status_transaksi == "4")
                                                <span class="badge text-bg-info">{{ $item -> statusTransaksi -> nama }}</span>
                                                @elseif ($item -> id_status_transaksi == "5")
                                                <span class="badge text-bg-warning">{{ $item -> statusTransaksi -> nama }}</span>
                                                @elseif ($item -> id_status_transaksi == "6")
                                                <span class="badge text-bg-danger">{{ $item -> statusTransaksi -> nama }}</span>
                                                @elseif ($item -> id_status_transaksi == "7")
                                                <span class="badge text-bg-primary">{{ $item -> statusTransaksi -> nama }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item -> id_status_pembayaran == "1")
                                                <span class="badge text-bg-success">{{ $item -> statusPembayaran -> nama }}</span>
                                                @elseif ($item -> id_status_pembayaran == "2")
                                                <span class="badge text-bg-warning">{{ $item -> statusPembayaran -> nama }}</span>
                                                @endif
                                            </td>
                                            <td>{{ rupiah($item -> total_tagihan) }}</td>
                                            <td>
                                            @if(auth()->user()->level=="admin")
                                                <a class="btn btn-primary" href={{ url('lihatTransaksi', $item->id_transaksi) }} role="button">Lihat</a>
                                                @if ($item->id_status_pembayaran == "2")
                                                <a class="btn btn-success" href={{ url('transaksiLunas', $item->id_transaksi) }} role="button">Lunas</a>
                                                @endif
                                                @if ($item->id_status_pembayaran == "1" && ($item->id_status_transaksi == "4" || $item->id_status_transaksi == "5" || $item->id_status_transaksi == "6"))
                                                <a class="btn btn-info" href={{ url('transaksiDiambil', $item->id_transaksi) }} role="button">Diambil</a>
                                                @endif
                                            @endif
                                            @if(auth()->user()->level=="pengguna")
                                                <a class="btn btn-primary" href={{ url('lihatTransaksiPengguna', $item->id_transaksi) }} role="button">Lihat</a>
                                                <a class="btn btn-danger" href={{ url('lihatTransaksiPengguna', $item->id_transaksi) }} role="button">Komplain</a>
                                            @endif
                                            <a class="btn btn-info" href={{ url('transaksiNota', $item->id_transaksi) }} role="button">Nota</a>
                                            <a class="btn btn-warning" href={{ url('transaksiUnduh/'.$item->id_transaksi.'/unduh') }} role="button">Nota</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                @include('sweetalert::alert')
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scriptsAdmin.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
    </body>
</html>
