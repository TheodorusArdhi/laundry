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
                    <div class="container-fluid px-4 fs-5">
                        <h1 class="mt-4">Poin</h1>
                        @if (Auth::user()->level != "pengguna")
                            <form method="POST" action="{{ url('admin/poin/user') }}">
                                {{ csrf_field() }} 
                                <label for="nama" class="fw-semibold form-label mb-0">Nama Pengguna</label>
                                <div class="row g-3 align-items-center">
                                    <div class="col-3">
                                        <select class="form-control form-control-lg select2" name="nama" id="nama" aria-label="Default select example" value="{{ Session::get('nama') }}">      
                                            @if ($user == "Semua")
                                                <option selected value="Semua">{{ $user }}</option>
                                                @foreach ($pengguna as $item)
                                                <option value="{{ $item->id_user }}">{{ $item->nama }}</option>
                                                @endforeach
                                            @else
                                                <option value="{{ $user->id_user }}">{{ $user->nama }}</option>
                                                <option value="Semua" >Semua</option>
                                                @foreach ($pengguna as $item)
                                                <option value="{{ $item->id_user }}">{{ $item->nama }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <div class="col-auto"><button type="submit" class="btn btn-secondary fw-semibold btn-block" role="button" data-toggle="tooltip" data-placement="top" title="Cek Pengguna">Cek</button></div>
                                    </div> 
                                </div>
                            </form>
                            @if ($user != "Semua")
                            <h5 class="mb-2 mt-1">Poin : {{ $sum }} </h5>
                            @endif
                        @else
                        @php
                            $poinUser = $poin->sum('jumlah');
                        @endphp
                        <h5 class="mb-2">Poin : {{ $poinUser }} </h5>
                        @endif
                        <div class="card mb-4 mt-4 ">                            
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                <a> <b class="fw-semibold">Riwayat Poin Transaksi</b></a>
                            </div>                            
                            <div class="card-body  ">
                                <table id="datatablesSimple">
                                    <thead >
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Nomor Transaksi</th>
                                            <th>Tanggal Tenggat</th>
                                            <th>Poin</th>
                                        </tr>
                                    </thead>
                                    <tfoot >
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Nomor Transaksi</th>
                                            <th>Tanggal Tenggat</th>
                                            <th>Poin</th>
                                        </tr>
                                    </tfoot>
                                    <?php
                                        $i=1;
                                    ?>
                                    <tbody >
                                        @foreach ($poin as $item)
                                        <tr>
                                            <th>{{ $i++ }}</th>
                                            <th>{{ $item -> user -> nama }}</th>
                                            <th>{{ $item -> transaksi -> no_transaksi }}</th>
                                            <th>{{ $item -> tgl_tenggat -> translatedFormat('l, d F Y')}}</th>
                                            <th>{{ $item -> jumlah }}</th>
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
