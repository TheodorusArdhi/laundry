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
                        <a class="btn btn-success" href="{{ url('admin/cabang/create') }}" role="button">Tambah</a>
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
                                            <th>Alamat</th>
                                            <th>Nomor Telepon</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot >
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Nomor Telepon</th>
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
                                                <a class="btn btn-warning" href={{ url('admin/cabang/'. $item->id_cabang.'/edit') }} role="button">Edit</a>
                                                @php
                                                    $hapus = App\Models\TransaksiDetail::where('id_transaksi', $item->id_cabang)->count();
                                                @endphp
                                                @if ($hapus == 0)
                                                <a class="btn btn-danger" href={{ url('admin/cabang/'. $item->id_cabang.'/delete') }} data-confirm-delete="true" role="button">Hapus</a>
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
