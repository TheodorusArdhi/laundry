<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template.head')
        <title>Pengguna - Sinar Laundry</title>
    </head>
    <body class="sb-nav-fixed">
        @include('template.topNav')
        <div id="layoutSidenav">
            @include('template.sideNav')
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Pengguna</h1>
                        @if (Auth::user()->level == "pemilik")
                        <a class="btn btn-laundry fw-semibold" style="font-size: 1.12rem;" href="{{ url('pemilik/user/create') }}" role="button" data-toggle="tooltip" data-placement="top" title="Tambah Admin">Tambah <i class="fa-solid fa-plus"></i></a>
                        @endif
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
                                            <th>Email</th>
                                            <th>Peran</th>
                                            <th>Notifikasi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot >
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Peran</th>
                                            <th>Notifikasi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <?php
                                        $i=1;
                                    ?>
                                    <tbody >
                                        @foreach ($pengguna as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $item -> nama }}</td>
                                            <td>{{ $item -> email }}</td>
                                            <td>{{ $item -> level }}</td>
                                            <td>
                                                @if($item -> notifikasi == "on")
                                                <span class="badge text-bg-success">Aktif</span>
                                                @elseif ($item -> notifikasi == null)
                                                <span class="badge text-bg-danger">Tidak Akif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-laundry" href={{ url('admin/user/'. $item->id_user.'/edit') }} role="button" data-toggle="tooltip" data-placement="top" title="Lihat Detil"><i class="fa-solid fa-magnifying-glass"></i></a>
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
