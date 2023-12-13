<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template.head')
        <title>Pengumuman - Sinar Laundry</title>
    </head>
    <body class="sb-nav-fixed">
        @include('template.topNav')
        <div id="layoutSidenav">
            @include('template.sideNav')
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Pengumuman</h1>
                        <a class="btn btn-success" href="{{ url('admin/pengumuman/create') }}" role="button">Tambah</a>
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
                                            <th>Judul</th>
                                            <th>Deskripsi</th>
                                            <th>Diskon</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot >
                                        <tr>
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Deskripsi</th>
                                            <th>Diskon</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <?php
                                        $i=1;
                                    ?>
                                    <tbody >
                                        @foreach ($pengumuman as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $item -> judul }}</td>
                                            <td>{{ $item -> deskripsi }}</td>
                                            <td>{{ $item -> diskon }} %</td>
                                            <td>
                                                @if($item -> status == "aktif")
                                                <span class="badge text-bg-success">Aktif</span>
                                                @elseif ($item -> status == "tidak aktif")
                                                <span class="badge text-bg-danger">Tidak Akif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-warning" href={{ url('admin/pengumuman/'. $item->id_pengumuman.'/edit') }} role="button">Edit</a>
                                                @php
                                                    $hapus = App\Models\Transaksi::where('id_pengumuman', $item->id_pengumuman)->count();
                                                @endphp
                                                @if ($hapus == 0)
                                                <a class="btn btn-danger" href={{ url('admin/pengumuman/'. $item->id_pengumuman.'/delete') }} data-confirm-delete="true" role="button">Hapus</a>
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
