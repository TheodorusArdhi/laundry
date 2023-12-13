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
                        <a class="btn btn-success" href="{{ url('admin/user/create') }}" role="button">Tambah Admin</a>
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
                                            <th>Email</th>
                                            <th>Nomor Telepon</th>
                                            <th>Peran</th>
                                            <th>Poin</th>
                                            <th>Notifikasi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot >
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Nomor Telepon</th>
                                            <th>Peran</th>
                                            <th>Poin</th>
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
                                            <td>{{ $item -> no_telp }}</td>
                                            <td>{{ $item -> level }}</td>
                                            <td>{{ $item -> poin }}</td>
                                            <td>
                                                @if($item -> notifikasi == "on")
                                                <span class="badge text-bg-success">Aktif</span>
                                                @elseif ($item -> notifikasi == null)
                                                <span class="badge text-bg-danger">Tidak Akif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-warning" href={{ url('admin/user/'. $item->id_user.'/edit') }} role="button">Edit</a>
                                                @php
                                                    $hapus = App\Models\Transaksi::where('id_user', $item->id_user)->orWhere('id_admin', $item->id_user)->count();
                                                @endphp
                                                @if ($hapus == 0)
                                                <a class="btn btn-danger" href={{ url('admin/user/'. $item->id_user.'/delete') }} data-confirm-delete="true" role="button">Hapus</a>
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
                @include('sweetalert::alert')
            </div>
        </div>
        @include('template.foot')
    </body>
</html>
