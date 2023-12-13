<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template.head')
        <title>Poin - Sinar Laundry</title>
    </head>
    <body class="sb-nav-fixed">
        @include('template.topNav')
        <div id="layoutSidenav">
            @include('template.sideNav')
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        @if (Auth::user()->level == "admin")
                        <h1 class="mt-4">Poin</h1>
                            <form method="POST" action="{{ url('admin/poin/user') }}">
                                {{ csrf_field() }} 
                                <label for="nama" class="fw-semibold form-label mt-2 mb-0">Nama Pengguna</label>
                                <div class="row g-3 align-items-center">
                                    <div class="col-3">
                                        <select class="form-control select2" name="nama" id="nama" aria-label="Default select example" value="{{ Session::get('nama') }}">
                                                <option selected >{{ $user }}</option>
                                                <option value="semua" >Semua</option>
                                                @foreach ($pengguna as $item)
                                                <option value="{{ $item->id_user }}">{{ $item->nama }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <div class="col-auto"><button type="submit" class="btn btn-primary btn-block" >Cek</button></div>
                                    </div> 
                                </div>
                            </form>
                        @else
                        <h1 class="mt-4">Poin : {{ $user->poin }}</h1>
                        @endif
                        <div class="card mb-4 mt-2 ">                            
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                <a> <b class="fw-semibold"></b></a>
                            </div>                            
                            <div class="card-body  ">
                                <table id="datatablesSimple">
                                    <thead >
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Nomor Transaksi</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Poin Masuk</th>
                                            <th>Poin Keluar</th>
                                        </tr>
                                    </thead>
                                    <tfoot >
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Nomor Transaksi</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Poin Masuk</th>
                                            <th>Poin Keluar</th>
                                        </tr>
                                    </tfoot>
                                    <?php
                                        $i=1;
                                        $sumPoinMasuk=0;
                                        $sumPoinKeluar=0;
                                    ?>
                                    <tbody >
                                        @foreach ($poin as $item)
                                        <tr>
                                            <th>{{ $i++ }}</th>
                                            <th>{{ $item -> user -> nama }}</th>
                                            <th>{{ $item -> no_transaksi }}</th>
                                            <th>{{ $item -> tgl_masuk -> translatedFormat('l, d F Y')}}</th>
                                            <th>{{ $item -> poin_masuk }}</th>
                                            <th>{{ $item -> poin_keluar }}</th>
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
    </body>
</html>
