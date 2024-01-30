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
                        @if (Auth::user()->level == "pemilik" || Auth::user()->level == "admin")
                            <form method="POST" action="{{ url('admin/poin/user') }}">
                                {{ csrf_field() }} 
                                <div class="row g-3 align-items-center">
                                    <div class="col-3">
                                        <label for="nama" class="fw-semibold form-label mb-0">Pengguna</label>
                                        <select class="form-select form-select-lg select2" name="nama" id="nama" aria-label="Default select example" value="{{ Session::get('nama') }}">      
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
                                    <div class="col-auto align-self-end mb-1">
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

                        <div class="card mb-4 mt-3 ">                            
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                <a> <b class="fw-semibold">Riwayat Poin Transaksi</b></a>
                            </div>                            
                            <div class="card-body  ">
                                <table id="datatablesSimple">
                                    <thead >
                                        <tr>
                                            <th>No</th>
                                            @if (Auth::user()->level == "pemilik" || Auth::user()->level == "admin")
                                            <th>Nama</th>
                                            @endif
                                            <th>Nomor Transaksi</th>
                                            <th>Tanggal Tenggat</th>
                                            <th>Poin</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tfoot >
                                        <tr>
                                            <th>No</th>
                                            @if (Auth::user()->level == "pemilik" || Auth::user()->level == "admin")
                                            <th>Nama</th>
                                            @endif
                                            <th>Nomor Transaksi</th>
                                            <th>Tanggal Tenggat</th>
                                            <th>Poin</th>
                                            <th>Status</th>
                                        </tr>
                                    </tfoot>
                                    <?php
                                        $i=1;
                                    ?>
                                    <tbody >
                                        @foreach ($poin as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            @if (Auth::user()->level == "pemilik" || Auth::user()->level == "admin")
                                            <td>{{ $item -> user -> nama }}</td>
                                            @endif
                                            <td>{{ $item -> transaksi -> no_transaksi }}</td>
                                            <td>{{ $item -> tgl_tenggat -> translatedFormat('l, d F Y')}}</td>
                                            <td>{{ $item -> jumlah }}</td>
                                            <td>
                                                @if($item -> status == "aktif")
                                                <span class="badge text-bg-success">Aktif</span>
                                                @elseif ($item -> status == "tidak aktif")
                                                <span class="badge text-bg-danger">Tidak Akif</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                @include('template.footer')
                @include('sweetalert::alert')
            </div>
        </div>
        @include('template.foot')
    </body>
</html>
