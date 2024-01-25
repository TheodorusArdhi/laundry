<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template.head')
        <title>Cabang - Sinar Laundry</title>
    </head>
    <body class="sb-nav-fixed">
        @include('template.topNav')
        <div id="layoutSidenav">
            @include('template.sideNav')
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Cabang</h1>
                        <a class="btn btn-laundry fw-semibold" style="font-size: 1.12rem;" href="{{ url('pemilik/cabang/create') }}" role="button" data-toggle="tooltip" data-placement="top" title="Tambah Cabang">Tambah <i class="fa-solid fa-plus"></i></a>
                        <div class="card mb-4 mt-2  fs-5">                            
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
                                            <th>Alamat</th>
                                            <th>Nomor Telepon</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot >
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Nomor Telepon</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <?php
                                        $i=1;
                                    ?>
                                    <tbody >
                                        @foreach ($cabang as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $item -> nama }}</td>
                                            <td>{{ $item -> alamat }}</td>
                                            <td>{{ $item -> no_telp }}</td>
                                            <td>
                                                @if($item -> status == "aktif")
                                                <span class="badge text-bg-success">Aktif</span>
                                                @elseif ($item -> status == "tidak aktif")
                                                <span class="badge text-bg-danger">Tidak Akif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-laundry" href={{ url('pemilik/cabang/'. $item->id_cabang.'/edit') }} role="button" data-toggle="tooltip" data-placement="top" title="Lihat Detil"><i class="fa-solid fa-magnifying-glass"></i></a>
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
    </body>
</html>
