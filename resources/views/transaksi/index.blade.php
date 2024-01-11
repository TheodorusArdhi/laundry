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
                        <h1 class="mt-4">Transaksi</h1>
                        @if (Auth::user()->level == "admin")
                        <a class="btn btn-laundry fw-semibold" style="font-size: 1.12rem;" href="{{ url('admin/transaksi/data') }}" role="button" data-toggle="tooltip" data-placement="top" title="Tambah Transaksi">Tambah <i class="fa-solid fa-plus"></i></a>
                        @endif
                        <div class="card mb-4 mt-2 fs-5">                            
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                <a> <b class="fw-semibold"></b></a>
                            </div>                            
                            <div class="card-body body">
                                <table id="datatablesSimple">
                                    <thead >
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Transaksi</th>
                                            <th>Nama</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot >
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Transaksi</th>
                                            <th>Nama</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <?php
                                        $i=1;
                                    ?>
                                    <tbody >
                                        @foreach ($transaksi as $item)
                                        <tr >
                                            <td >{{ $i++ }}</td>
                                            <td>{{ $item -> no_transaksi }}</td>
                                            <td>{{ $item -> user -> nama }}</td>
                                            <td>{{ $item -> tgl_masuk -> translatedFormat('l, d F Y') }}</td>
                                            <td>
                                                Transaksi: 
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
                                                @elseif ($item -> id_status_transaksi == "8")
                                                <span class="badge text-bg-dark">{{ $item -> statusTransaksi -> nama }}</span>
                                                @endif

                                                Pembayaran: 
                                                @if($item -> id_status_pembayaran == "1")
                                                <span class="badge text-bg-success">{{ $item -> statusPembayaran -> nama }}</span>
                                                @elseif ($item -> id_status_pembayaran == "2")
                                                <span class="badge text-bg-warning">{{ $item -> statusPembayaran -> nama }}</span>
                                                @endif
                                            </td>
                                            <td>
                                            @if(auth()->user()->level=="admin" || auth()->user()->level=="owner")
                                                <a class="btn btn-laundry" href={{ url('admin/transaksi/'. $item->id_transaksi.'/edit') }} role="button" data-toggle="tooltip" data-placement="top" title="Lihat Detil"><i class="fa-solid fa-magnifying-glass"></i></a>
                                            @endif
                                            @if(auth()->user()->level=="pengguna")
                                                <a class="btn btn-laundry" href={{ url('user/transaksi/'. $item->id_transaksi.'/edit') }} role="button" data-toggle="tooltip" data-placement="top" title="Lihat Detil"><i class="fa-solid fa-magnifying-glass"></i></a>
                                            @endif
                                            {{--  <a class="btn btn-info" href={{ url('transaksiNota', $item->id_transaksi) }} role="button">Nota</a>  --}}
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
        @include('template.foot')
        <script>
            body {
                font-family: sans-serif;
                font-size: 2rem;
              }
        </script>
    </body>
</html>
