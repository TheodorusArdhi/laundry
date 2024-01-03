<!DOCTYPE html>
<html lang="en">
    <head>
        @include('template.head')
        <title>Layanan - Sinar Laundry</title>
    </head>
    <body class="sb-nav-fixed">
        @include('template.topNav')
        <div id="layoutSidenav">
            @include('template.sideNav')
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Layanan</h1>
                        <a class="btn btn-success fw-semibold" style="font-size: 1.12rem;" href="{{ url('owner/layanan/create') }}" role="button">Tambah <i class="fa-solid fa-plus"></i></a>
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
                                            <th>Harga</th>
                                            <th>Durasi</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot >
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Harga</th>
                                            <th>Durasi</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <?php
                                        $i=1;
                                    ?>
                                    <tbody >
                                        @foreach ($layanan as $item)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $item -> nama }}</td>
                                            <td>{{ rupiah($item -> harga) }}</td>
                                            <td>{{ $item -> durasi }} Hari</td>
                                            <td>
                                                @if($item -> status == "aktif")
                                                <span class="badge text-bg-success">Aktif</span>
                                                @elseif ($item -> status == "tidak aktif")
                                                <span class="badge text-bg-danger">Tidak Akif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-warning" href={{ url('owner/layanan/'. $item->id_layanan.'/edit') }} role="button" data-toggle="tooltip" data-placement="top" title="Detil"><i class="fa-solid fa-magnifying-glass"></i></a>
                                                @php
                                                    $hapus = App\Models\TransaksiDetail::where('id_layanan', $item->id_layanan)->count();
                                                @endphp
                                                @if ($hapus == 0)
                                                <a class="btn btn-danger" href={{ url('owner/layanan/'. $item->id_layanan.'/delete') }} data-confirm-delete="true" role="button" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa-solid fa-trash"></i></a>
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
